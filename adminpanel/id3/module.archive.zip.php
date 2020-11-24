<?php

/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at https://github.com/JamesHeinrich/getID3       //
//            or https://www.getid3.org                        //
//            or http://getid3.sourceforge.net                 //
//  see readme.txt for more details                            //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.archive.zip.php                                      //
// module for analyzing pkZip files                            //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

if (!defined('GETID3_INCLUDEPATH')) { // prevent path-exposing attacks that access modules directly on public webservers
	exit;
}

class getid3_zip extends getid3_handler
{
	/**
	 * @return bool
	 */
	public function Analyze() {
		$info = &$this->getid3->info;

		$info['fileformat']      = 'zip';
		$info['zip']['encoding'] = 'ISO-8859-1';
		$info['zip']['files']    = array();

		$info['zip']['compressed_size']   = 0;
		$info['zip']['uncompressed_size'] = 0;
		$info['zip']['entries_count']     = 0;

		if (!getid3_lib::intValueSupported($info['filesize'])) {
			$this->error('File is larger than '.round(PHP_INT_MAX / 1073741824).'GB, not supported by PHP');
			return false;
		} else {
			$EOCDsearchData    = '';
			$EOCDsearchCounter = 0;
			while ($EOCDsearchCounter++ < 512) {

				$this->fseek(-128 * $EOCDsearchCounter, SEEK_END);
				$EOCDsearchData = $this->fread(128).$EOCDsearchData;

				if (strstr($EOCDsearchData, 'PK'."\x05\x06")) {

					$EOCDposition = strpos($EOCDsearchData, 'PK'."\x05\x06");
					$this->fseek((-128 * $EOCDsearchCounter) + $EOCDposition, SEEK_END);
					$info['zip']['end_central_directory'] = $this->ZIPparseEndOfCentralDirectory();

					$this->fseek($info['zip']['end_central_directory']['directory_offset']);
					$info['zip']['entries_count'] = 0;
					while ($centraldirectoryentry = $this->ZIPparseCentralDirectory()) {
						$info['zip']['central_directory'][] = $centraldirectoryentry;
						$info['zip']['entries_count']++;
						$info['zip']['compressed_size']   += $centraldirectoryentry['compressed_size'];
						$info['zip']['uncompressed_size'] += $centraldirectoryentry['uncompressed_size'];

						//if ($centraldirectoryentry['uncompressed_size'] > 0) { zero-byte files are valid
						if (!empty($centraldirectoryentry['filename'])) {
							$info['zip']['files'] = getid3_lib::array_merge_clobber($info['zip']['files'], getid3_lib::CreateDeepArray($centraldirectoryentry['filename'], '/', $centraldirectoryentry['uncompressed_size']));
						}
					}

					if ($info['zip']['entries_count'] == 0) {
						$this->error('No Central Directory entries found (truncated file?)');
						return false;
					}

					if (!empty($info['zip']['end_central_directory']['comment'])) {
						$info['zip']['comments']['comment'][] = $info['zip']['end_central_directory']['comment'];
					}

					if (isset($info['zip']['central_directory'][0]['compression_method'])) {
						$info['zip']['compression_method'] = $info['zip']['central_directory'][0]['compression_method'];
					}
					if (isset($info['zip']['central_directory'][0]['flags']['compression_speed'])) {
						$info['zip']['compression_speed']  = $info['zip']['central_directory'][0]['flags']['compression_speed'];
					}
					if (isset($info['zip']['compression_method']) && ($info['zip']['compression_method'] == 'store') && !isset($info['zip']['compression_speed'])) {
						$info['zip']['compression_speed']  = 'store';
					}

					// secondary check - we (should) already have all the info we NEED from the Central Directory above, but scanning each
					// Local File Header entry will
					foreach ($info['zip']['central_directory'] as $central_directory_entry) {
						$this->fseek($central_directory_entry['entry_offset']);
						if ($fileentry = $this->ZIPparseLocalFileHeader()) {
							$info['zip']['entries'][] = $fileentry;
						} else {
							$this->warning('Error parsing Local File Header at offset '.$central_directory_entry['entry_offset']);
						}
					}

					if (!empty($info['zip']['files']['[Content_Types].xml']) &&
					    !empty($info['zip']['files']['_rels']['.rels'])      &&
					    !empty($info['zip']['files']['docProps']['app.xml']) &&
					    !empty($info['zip']['files']['docProps']['core.xml'])) {
							// http://technet.microsoft.com/en-us/library/cc179224.aspx
							$info['fileformat'] = 'zip.msoffice';
							if (!empty($ThisFileInfo['zip']['files']['ppt'])) {
								$info['mime_type'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
							} elseif (!empty($ThisFileInfo['zip']['files']['xl'])) {
								$info['mime_type'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
							} elseif (!empty($ThisFileInfo['zip']['files']['word'])) {
								$info['mime_type'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
							}
					}

					return true;
				}
			}
		}

		if (!$this->getZIPentriesFilepointer()) {
			unset($info['zip']);
			$info['fileformat'] = '';
			$this->error('Cannot find End Of Central Directory (truncated file?)');
			return false;
		}

		// central directory couldn't be found and/or parsed
		// scan through actual file data entries, recover as much as possible from probable trucated file
		if ($info['zip']['compressed_size'] > ($info['filesize'] - 46 - 22)) {
			$this->error('Warning: Truncated file! - Total compressed file sizes ('.$info['zip']['compressed_size'].' bytes) is greater than filesize minus Central Directory and End Of Central Directory structures ('.($info['filesize'] - 46 - 22).' bytes)');
		}
		$this->error('Cannot find End Of Central Directory - returned list of files in [zip][entries] array may not be complete');
		foreach ($info['zip']['entries'] as $key => $valuearray) {
			$info['zip']['files'][$valuearray['filename']] = $valuearray['uncompressed_size'];
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function getZIPHeaderFilepointerTopDown() {
		$info = &$this->getid3->info;

		$info['fileformat'] = 'zip';

		$info['zip']['compressed_size']   = 0;
		$info['zip']['uncompressed_size'] = 0;
		$info['zip']['entries_count']     = 0;

		rewind($this->getid3->fp);
		while ($fileentry = $this->ZIPparseLocalFileHeader()) {
			$info['zip']['entries'][] = $fileentry;
			$info['zip']['entries_count']++;
		}
		if ($info['zip']['entries_count'] == 0) {
			$this->error('No Local File Header entries found');
			return false;
		}

		$info['zip']['entries_count']     = 0;
		while ($centraldirectoryentry = $this->ZIPparseCentralDirectory()) {
			$info['zip']['central_directory'][] = $centraldirectoryentry;
			$info['zip']['entries_count']++;
			$info['zip']['compressed_size']   += $centraldirectoryentry['compressed_size'];
			$info['zip']['uncompressed_size'] += $centraldirectoryentry['uncompressed_size'];
		}
		if ($info['zip']['entries_count'] == 0) {
			$this->error('No Central Directory entries found (truncated file?)');
			return false;
		}

		if ($EOCD = $this->ZIPparseEndOfCentralDirectory()) {
			$info['zip']['end_central_directory'] = $EOCD;
		} else {
			$this->error('No End Of Central Directory entry found (truncated file?)');
			return false;
		}

		if (!empty($info['zip']['end_central_directory']['comment'])) {
			$info['zip']['comments']['comment'][] = $info['zip']['end_central_directory']['comment'];
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function getZIPentriesFilepointer() {
		$info = &$this->getid3->info;

		$info['zip']['compressed_size']   = 0;
		$info['zip']['uncompressed_size'] = 0;
		$info['zip']['entries_count']     = 0;

		rewind($this->getid3->fp);
		while ($fileentry = $this->ZIPparseLocalFileHeader()) {
			$info['zip']['entries'][] = $fileentry;
			$info['zip']['entries_count']++;
			$info['zip']['compressed_size']   += $fileentry['compressed_size'];
			$info['zip']['uncompr
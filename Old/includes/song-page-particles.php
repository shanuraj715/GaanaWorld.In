 <?php if(rand(0, 1) == 0){ ?>
	<div  class="particles-js particles_hide">
		<div id="particles-js"></div>
	</div>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js/particles/particles.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js/particles/app.js"></script>
<?php
}
else{ ?>
	<div class="particles-js particles_hide">
		<div id="sketch-particle"></div>
		<i class="fas fa-times particle-close"></i>
		<style type="text/css">
			.particle-close{
				position: absolute;
				top: 20px;
				right: 20px;
				font-size: 20px;
				border: solid 1px var(--theme-gray);
				background-color: transparent;
				padding: 2px;
				color: var(--theme-gray);
			}
		</style>
	</div>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js/sketch-particle/sketch.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>js/sketch-particle/sketch-func.js"></script>
<?php
} ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/particle.js?id=<?php echo rand(0, 9);?>"></script>
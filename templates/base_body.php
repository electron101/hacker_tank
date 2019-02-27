<body class="hold-transition skin-black layout-boxed sidebar-mini">
	<div class="wrapper">
		<?php include("base_body_header.php"); ?>
		<?php include("base_body_aside.php");  ?>
		<!-- Слой контента -->
		<div class="content-wrapper">
			<!-- Основной контент -->
			<section class="content container-fluid">
				<?php 
				if ($CONTENT != "") {
					if ($TYPE_CONTENT == "html")
					echo $CONTENT;
					else if ($TYPE_CONTENT == "file")
					require $CONTENT;
					else
					echo 'Тип содержимого контента не установлен!';
				}
				?>
			</section>
		</div>
		<?php include("base_body_footer.php");  ?>	
	</div>
	<!-- Загрузка базового js  -->
	<?php Esl::LoadBaseJS(); ?>
</body>
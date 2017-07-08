<?php 
	
	## Render Val
	function renderVal($val){

		if (is_array($val) || is_object($val) ) {
			$cl = 'pr_obj';
			$name = 'Object';

			if (is_array($val)) {
				$cl = '';
				$name = 'Array';
			}
			
			$_ = '';
			// echo '<pre>:';
			// print_r($val);
			// echo ':</pre>';

			// render($val);
			if ($val) {
				foreach ($val as $key => $value) {
					$_ .= '<li><span class="pr_key" onclick="pr_key(this);">['.$key.']</span> <span class="pr_eqr">=></span> <span class="pr_value open">'. renderVal($value) .'</span></li>';
				}
			}
			
			$o = "<ul class='pr_arr $cl'><b>$name</b> (<span class='pr_val_elipse'></span>$_)</ul>";
		}else if (is_numeric($val)) {
			$o = "<span class='pr_int'>$val</span>";
		}else{
			$o = "<span class='pr_normal_val'>$val</span>";
		}

		return $o;
	}

	### Codes render, just like command prompt ;)
	function render($val='', $script = false)
	{
		$cache_val = $val;
		$row = print_r($val, true);
		if (!$script) {
			$details = debug_backtrace();
			$file = $details[0]['file'];
			$line = $details[0]['line'];
		}else{
			$file = $script[0];
			$line = $script[1];
		}

		if ($val!='') {
			$val = renderVal($val);
		}else{
			$val='<div class="php_render_empty">empty <b>array</b> or <b>string</b>!</div>';
		}

		if (is_object($cache_val) || is_array($cache_val)) {
			echo '<pre class="php_render pr_apply_style_styled php_render_arr_obj">';
			echo '<div class="pr_controls"><div class="pr_styles"><span class="pr_style pr_style_row" onclick="pr_style(this, \'row\');">row</span><span class="pr_style pr_style_normal" onclick="pr_style(this, \'normal\');">normal</span><span class="pr_style pr_styled" onclick="pr_style(this, \'styled\');">styled</span><br><span class="pr_style pr_collapse_all _expand" onclick="pr_collapse_all(this);">Collapse All</span></div></div>';
		}else{
			echo '<pre class="php_render pr_apply_style_styled">';
		}
		echo "<div class='php_render_wrap'>$val</div>";
		echo "<div class='php_render_wrap_row'>$row</div>";
		echo '<div class="php_render_footer">'.$file.' on line '.$line.'</div></pre><div style="clear:both;"></div>';


     	$printStyle = true;
     	if (isset($GLOBALS['render_style'])) {
     		$printStyle = false;
     	}

     	if (!isset($GLOBALS['render_style'])) {
     		$GLOBALS['render_style'] = true;
     	}

     	if ($printStyle) {
     		?>
			<style>
				.php_render{
					font-size: 13px;
					font-style:normal;
					font-family: monospace;
					background: #0C1D33;
					color: #68F595;
					color: #89b7ca;
					word-wrap: break-word;
					position: relative;
					z-index: 999999999999;
					margin-bottom:5px;
					text-align:left;
					white-space: pre-wrap;
				}
				.php_render *{
					padding: 0;
					margin: 0;
					-webkit-box-sizing: border-box;
					-moz-box-sizing: border-box;
					box-sizing: border-box;
				}
				.php_render li{
					list-style: none;
				}
				.php_render_empty{
					padding:5px;
					color:rgb(255, 89, 89);
				}
				.php_render_wrap{
					padding: 7px 10px 0 10px;
					display: none;
					min-height: 28px;
				}
				.php_render_arr_obj{
					min-height: 68px;
				}
				.php_render_footer{
					padding: 7px 10px;
					background-color: rgba(255, 255, 255, 0.04);
					color: #6A81A0;
					font-size: 11px;
					text-align:left;
				}
				.php_render_footer:hover{
					color: #fff;
				}
				.php_render details{
					display: block;
					/*padding-left: 50px;*/
				}
				.php_render summary{
					outline:0;
					color: red;
				}
				.php_render summary.array{
					outline:0;
					color:#d7503c;
				}
				.php_render details details summary{
					/*padding-left: 40px;*/
				}
				.php_render details > summary{
					/*padding-left: 50px;*/
				}
				.php_render .pr_arr{
					display: table-cell;
					position: relative;
				}
				.php_render .pr_arr:after{
					content: '';
				    position: absolute;
				    left: 2px;
				    top: 20px;
				    bottom: 16px;
				    width: 1px;
				    border-left: 1px dotted;
				    opacity: .2;
				}
				.php_render .pr_key{
					color: #FF715C;
					font-weight: bold;
					cursor: pointer;
				}
				.php_render .pr_key:hover{
					background: rgba(244, 67, 54, 0.21);
				}
				.php_render .pr_eqr{
					color: #d7503c;
				}
				.php_render .pr_value{
					/*color: #68F595;*/
				}
				.php_render .pr_value.close > .pr_arr > li/* ,
				.php_render._collapse .pr_arr > li */{
					display: none;
				}
				/*.php_render .pr_arr:before{
					content: '(';
				}
				.php_render .pr_arr:after{
					content: ')';
				}*/
				.php_render .pr_arr li{
					padding: 1px 30px;
				}
				.php_render .pr_arr .pr_arr li{
					margin-left: -30px;
				}
				.php_render .pr_arr span{
					/*display: inline-block;*/
				}
				.php_render .pr_int{
					color: #686bf5;
				}
				.php_render .pr_normal_val{
					color: #68F595;
				}
				.php_render .pr_value.close > .pr_arr > .pr_val_elipse:after/* ,
				.php_render._collapse .pr_val_elipse:after */{
					content: '\00b7\00b7\00b7';
				    border-radius: 3px;
				    letter-spacing: -2px;
				    padding: 0px 4px 0px 2px;
				    font-size: 84%;
				    line-height: 8px;
				    display: inline-block;
				    background: #63c0e6;
				    color: #000;
				}
				.php_render .pr_styles{
					position: absolute;
					top: 0;
					right: 0;
					margin: 20px;
					text-align: right;
				}
				.php_render .pr_style{
					display: inline-block;
					margin-left: 10px;
					background: #fff;
					padding: 2px 8px;
					border-radius: 2px;
					color: #0c1d33;
					cursor: pointer;
					opacity: .3;
				}
				.php_render_wrap_row{
					display: none;
					color: #000;
					white-space: normal;
					padding: 0 20px;
				}
				.php_render.pr_apply_style_row .pr_style_row,
				.php_render.pr_apply_style_normal .pr_style_normal,
				.php_render.pr_apply_style_styled .pr_styled{
					opacity: .8;
				}
				.php_render.pr_apply_style_row,
				.php_render.pr_apply_style_normal{
					background: #fff;
				}
				.php_render.pr_apply_style_normal *{
					color: #000;
				}
				.php_render.pr_apply_style_row .php_render_wrap_row,
				.php_render.pr_apply_style_normal .php_render_wrap,
				.php_render.pr_apply_style_styled .php_render_wrap{
					display: block;
				}
				.php_render._collapse .pr_collapse_all{
					opacity: .8;
				}
			</style>
			<script>
				
				function pr_key(that){
					var $this = that.nextSibling.nextElementSibling.nextElementSibling;
					$this.classList.toggle('open');
					$this.classList.toggle('close');
				}

				function pr_style(that, style) {
					var $ele = that.parentElement.parentElement.parentElement;
					$ele.classList.remove("pr_apply_style_row");
					$ele.classList.remove("pr_apply_style_normal");
					$ele.classList.remove("pr_apply_style_styled");
					$ele.classList.add("pr_apply_style_" + style);
				}

				function pr_collapse_all(that) {
					var $ele = that.parentElement.parentElement.parentElement;
					$ele.classList.toggle('_collapse');
					$ele.classList.toggle('_expand');

					var $all = $ele.querySelectorAll(".pr_value");

					for (var i = 0; i < $all.length; i++) {
						// $all[i]
						$all[i].classList.toggle('open');
						$all[i].classList.toggle('close');
					}

					if (that.innerHTML == "Collapse All") {
					    that.innerHTML = "Expand All";
					} else {
					    that.innerHTML = "Collapse All";
					}
				}

			</script>
     		<?php
     	}
	}

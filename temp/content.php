
	<div class="content">

	<!--常用信息-->
		<div class="w1226 h300 height_hover">
			<div class="left">
				<div class="search"><!--搜索-->
					<input id="search" type="text" value="" name="search" placeholder="单号、渠道号"/>
					<input onclick="search('search')" type="button" name="button" value="搜 索" />
				</div>
				<div class="info_table">
					<!--待处理订单信息-->
					<table width="100%" cellspacing="0" cellpadding="0" id="order_table">
					
						<tr>
							<th>单号</th>
							<th>名称</th>
							<th>数量</th>
							<th>规格</th>
							<th>日期</th>
							<th>地址</th>
							<th>方式</th>
						</tr>
					</table>
				</div>
				<!--分页块--
				<div class="paging">
					<a href="#">首页</a>
					<a href="#">1</a>
					<a href="#">2</a>
					<a href="#">尾页</a>
				</div>
				-->
			</div>
			<div class="right">
				<div class="clock">
				<!--多国时间日期、天气-->
					<div class="time_bj">
						<ul>
							<li class="time_bj_year" id="time_bj_yaer">2000-01-01</li>
							<li class="time_bj_date" id="time_bj_date">00:00:00</li>
							<li><iframe width="290" scrolling="no" height="22" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=1&icon=1&wind=1&num=1&site=14"></iframe></li>
						</ul>
					</div>
					<div></div>
				</div>
			</div>
		</div>
	<!--订单列表-->
		<div class="w1226 max_height height_hover">
			<ul class="order_nav">
				<li>状态</li>
				<li>管理</li>
				<li>单号</li>
				<li>数量</li>
				<li>图片</li>
				<li>规格</li>
				<li>要求</li>
				<li>日期</li>
				<li>地址</li>
				<li>方式</li>
			</ul>
			<div class="order_list" id="order_All_list">
				
			</div>
			<!--分页块-->
			<div class="paging">
				<a href="#">首页</a>
				<a href="#">1</a>
				<a href="#">2</a>
				<a href="#">尾页</a>
			</div>
		</div>
	<!---->
		<div class="w1226"></div>
	</div>


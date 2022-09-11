<!--
총 매출

매점 협동 조합 판매자 사이트 디자인 34p
 -->

<?php

require_once ("./view/user_auth.php");

$auth = getAuth();
if ( $auth === '소비자' || $auth === '조합원' ) {
	echo "
	<script>
		alert('권한이 없습니다');
		window.location.href = './index.php?id=home';
	</script>
	";
}

?>

<div id="all_result-container">

	<div id="all_result-table-wrap">
		
		<div id="all_result-filter-wrap" class="w3-bar w3-card">
			
			<div id="all_result-data-type-selector" class="w3-bar-item w3-dropdown-hover w3-border">
					
				<button class="w3-button w3-large">
					<?php 
					if(isset($_POST['data_type'])) {
						echo $_POST['data_type'];
					} else {
						echo "전체선택";
					}
					?>
				</button>
					
				<div class="w3-dropdown-content w3-bar-block w3-border">
					<div class="w3-bar-item w3-button w3-large all" onclick="clickHandler(event)">전체선택</div>
					<div class="w3-bar-item w3-button w3-large sell" onclick="clickHandler(event)">판매</div>
					<div class="w3-bar-item w3-button w3-large charge" onclick="clickHandler(event)">충전</div>
					<div class="w3-bar-item w3-button w3-large stock" onclick="clickHandler(event)">재고구매</div>
				</div>
				
			</div>
			
			<div class="w3-bar-item w3-border">
				<input 
					   type="date" 
					   class="w3-midium all_result-searchInfo noStyle" 
					   value="<?php if(isset($_POST['data_type'])) {
										echo $_POST['begin_date'];
									}?>"
				>
			</div>
			
			<div class="w3-bar-item w3-border">
				<input 
					   type="date" 
					   class="w3-midium all_result-searchInfo noStyle"
					   value="<?php if(isset($_POST['data_type'])) {
										echo $_POST['end_date'];
									}?>"
				>
			</div>
			
			<div class="w3-bar-item" title="끝 날짜를 시작 날짜로 설정">
				<input type="checkbox" class="w3-border noStyle" onclick="setEndDateToBegin(event)">
			</div>
			
			<div class="all_result-data-type-hide-show w3-bar-item w3-border all sell charge stock">
				<input
					type="text"
					id="search-seller"
					class="w3-midium all_result-searchInfo noStyle"
					placeholder="승인자"
					value="<?php if(isset($_POST['data_type'])) {
										echo $_POST['seller_name'];
									}?>"
				>
			</div>
			
			<div class="all_result-data-type-hide-show w3-bar-item w3-hide w3-border all sell charge">
				<input
					type="text"
					id="search-consumer"
					class="w3-midium all_result-searchInfo noStyle"
					placeholder="소비자"
					value="<?php if(isset($_POST['data_type'])) {
										echo $_POST['consumer_name'];
									}?>"
				>
			</div>
			
			<div class="all_result-data-type-hide-show w3-bar-item w3-hide w3-border sell stock">
				<input
					type="text"
					id="search-product"
					class="w3-midium all_result-searchInfo noStyle"
					placeholder="상품명"
					value="<?php if(isset($_POST['data_type'])) {
										echo $_POST['goods_name'];
									}?>"
				>
			</div>
			
			<div id="all_result-data-type-selector" class="all_result-data-type-hide-show w3-bar-item w3-dropdown-hover w3-border charge">
					
				<button class="w3-button w3-large">
					충전 종류
				</button>
					
				<div class="w3-dropdown-content w3-bar-block w3-border">
					<label class="w3-bar-item w3-button w3-large" data-charge-type="all" onclick="clickHandler(event)">
						전체선택
					</label>
					
					<label class="w3-bar-item w3-button w3-large" data-charge-type="일반충전" onclick="clickHandler(event)">
						일반충전
					</label>
					
					<label class="w3-bar-item w3-button w3-large" data-charge-type="쿠폰" onclick="clickHandler(event)">
						쿠폰
					</label>
					
					<label class="w3-bar-item w3-button w3-large" data-charge-type="기타" onclick="clickHandler(event)">
						기타
					</label>
				</div>
				
				<input id="charge_type" type="hidden" class="all_result-searchInfo">
				
			</div>
			
			<form action="./index.php?id=all_result" class="w3-bar-item w3-border" method='post'>
				<input type='button' class="w3-button w3-large" value="검색" onclick="clickHandler(event)">
				
				<input type='hidden' name='data_type'>
				<input type='hidden' name='begin_date'>
				<input type='hidden' name='end_date'>
				<input type='hidden' name='seller_name'>
				<input type='hidden' name='consumer_name'>
				<input type='hidden' name='goods_name'>
				<input type='hidden' name='charge_type'>
			</form>
		</div>

		<table id="all_result-table" class="w3-table-all w3-card">
			<tr id="all_result-table-head" class='color-gray-warm'>
				<td class="w3-container all sell charge stock">거래 종류</td>
				<td class="w3-container all sell charge stock">일시</td>
				<td class="w3-container all sell charge">사용 금액 / 총계: 계산중..</td>
				<td class="w3-container all sell charge stock">승인자</td>

				<td class="w3-container w3-hide sell stock">상품명</td>
				<td class="w3-container w3-hide sell stock">개수</td>
				<td class="w3-container w3-hide sell">상품 금액</td>
				<td class="w3-container w3-hide all sell charge">소비자</td>
				<td class="w3-container w3-hide charge">비고</td>
			</tr>
			
			<?php

			function printRow() {
				 
				$mysqli = new mysqli("localhost", CONF_DB['db_user'], CONF_DB['db_password'], CONF_DB['db_name']);
				mysqli_set_charset($mysqli, 'utf8');
				
				// Check connection
				if ($mysqli -> connect_errno) {
				  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
				  exit();
				}
				
				if(isset($_POST['data_type'])) {
					
					if($_POST['begin_date'] === "") {
						$_POST['begin_date'] = '2000-01-01';
					}
					
					if($_POST['end_date'] === "") {
						$_POST['end_date'] = '2100-01-01';
					}
					
					if($_POST['seller_name'] === "") {
						$_POST['seller_name'] = '%';
					}
					
					if($_POST['consumer_name'] === "") {
						$_POST['consumer_name'] = '%';
					}
					
					if($_POST['goods_name'] === "") {
						$_POST['goods_name'] = '%';
					}
					
					
					
					switch ($_POST['data_type']) {
						case '전체선택':
							$selectQuery = "
							
							SELECT * FROM(
							
								SELECT 
									'충전' AS 'data_type',
									cr.time, 
									cr.money, 
									u.name AS seller_name,
									uu.name AS customer_name
								FROM 
									`charge_record` AS cr
								JOIN 
									`user` AS u
								JOIN
									`user` AS uu
								ON 
									u.id = cr.seller_id
								AND 
									uu.id = cr.customer_id

								UNION

								SELECT 
									IF(sr.goods_num > 0, '판매', '환불') AS 'data_type',
									sr.time, 
									(sr.goods_num * sr.goods_price) AS 'money', 
									u.name AS seller_name,
									uu.name AS customer_name
								FROM 
									`sales_record` AS sr
								JOIN 
									`user` AS u
								JOIN
									`user` AS uu
								ON 
									u.id = sr.seller_id
								AND 
									uu.id = sr.customer_id

							) t
							
							WHERE 
								'{$_POST['begin_date']} 00:00:00' <= t.time 
								AND t.time <= '{$_POST['end_date']} 23:59:59' 
								AND t.seller_name LIKE '{$_POST['seller_name']}'
								AND t.customer_name LIKE '{$_POST['consumer_name']}'
								
							ORDER BY time DESC";
							break;
							
						case '판매':
							$selectQuery = "
							
							SELECT * FROM (
							
								SELECT
									IF(sr.goods_num > 0, '판매', '환불') AS 'data_type',
									sr.time,
									(sr.goods_num * sr.goods_price) AS 'money',
									u.name AS 'seller_name',
									g.name AS 'goods_name',
									sr.goods_num,
									sr.goods_price,
									uu.name AS 'consumer_name'
								FROM
									`sales_record` AS sr
								JOIN
									`user` AS u
								JOIN
									`user` AS uu
								JOIN
									`goods` AS g
								ON
									u.id = sr.seller_id AND uu.id = sr.customer_id AND g.id = sr.goods_id
							) t
							
							WHERE 
								'{$_POST['begin_date']} 00:00:00' <= t.time 
								AND t.time <= '{$_POST['end_date']} 23:59:59' 
								AND t.seller_name LIKE '{$_POST['seller_name']}'
								AND t.consumer_name LIKE '{$_POST['consumer_name']}'
								AND t.goods_name LIKE '{$_POST['goods_name']}'
								
							ORDER BY
								TIME
							DESC
								";
							break;
						case '충전':
							$charge_type = $_POST['charge_type'];
							$selectQuery = "
							
							SELECT * FROM (
							
								SELECT
									'충전' AS 'data_type',
									cr.time,
									cr.money,
									u.name AS 'seller_name',
									uu.name AS 'consumer_name',
									cr.note
								FROM
									`charge_record` AS cr
								JOIN
									`user` AS u
								JOIN
									`user` AS uu
								ON
									u.id = cr.seller_id AND uu.id = cr.customer_id
							) t
							
							WHERE 
								'{$_POST['begin_date']} 00:00:00' <= t.time 
								AND t.time <= '{$_POST['end_date']} 23:59:59' 
								AND t.seller_name LIKE '{$_POST['seller_name']}'
								AND t.consumer_name LIKE '{$_POST['consumer_name']}'
								AND(";
							
							$putOr = FALSE;
							
							if(strpos($charge_type, '일반충전') !== FALSE) {
								$selectQuery .= "(t.note LIKE '%일반충전%')";
								$putOr = TRUE;
							}
							
							if(strpos($charge_type, '쿠폰') !== FALSE) {
								if($putOr) $selectQuery .= "OR";
								$selectQuery .= "(t.note LIKE '%쿠폰%')";
								$putOr = TRUE;
							}
							
							if(strpos($charge_type, '기타') !== FALSE) {
								if($putOr) $selectQuery .= "OR ";
								$selectQuery .= "NOT(t.note LIKE '%일반충전%' OR t.note LIKE '%쿠폰%')";
								$putOr = TRUE;
							}
							
							if(!$putOr) {
								$selectQuery .= '1 = 1';
							}
							
							$selectQuery .=
							")ORDER BY
								TIME
							DESC
								
							";
							break;
						case '재고구매':
							$selectQuery = "
							
							SELECT * FROM (
							
								SELECT
									'재고구매' AS 'data_type',
									st.time,
									u.name AS 'seller_name',
									g.name AS 'goods_name',
									st.goods_num
								FROM
									`stock_record` AS st
								JOIN
									`user` AS u
								JOIN
									`goods` AS g
								ON
									u.id = st.seller_id AND g.id = st.goods_id
							) t
							
							WHERE 
								'{$_POST['begin_date']} 00:00:00' <= t.time 
								AND t.time <= '{$_POST['end_date']} 23:59:59' 
								AND t.seller_name LIKE '{$_POST['seller_name']}'
								AND t.goods_name LIKE '{$_POST['goods_name']}'
								
							ORDER BY
								TIME
							DESC
								";
							break;
					}
					
					$result = $mysqli -> query($selectQuery);
					
					$printTable = "";
					
					while ($row = $result -> fetch_assoc()) {
						
						$printTable .= "<tr>";
						
						foreach($row as $key => $value) {
							
							$printTable .= "<td class=all_result-table-column-{$key}>{$value}</td>";
							
						}
						
						$printTable .= "</tr>";
						
					}
					
					return $printTable;
				}
				
				$mysqli -> close();
			
			}
			
			echo printRow();
			?>
		</table>
	</div>
	<script src="./assets/js/all_result_table.js"></script>
	
	<script>
		<?php 
		if(isset($_POST['data_type'])) {
			echo "DATA_TYPE='{$_POST['data_type']}';";
		}
		?>
	</script>
	
</div>
var dataList;

Date.prototype.getWeek = function (dowOffset) {
/*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

    dowOffset = typeof(dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
    var newYear = new Date(this.getFullYear(),0,1);
    var day = newYear.getDay() - dowOffset; //the day of week the year begins on
    day = (day >= 0 ? day : day + 7);
    var daynum = Math.floor((this.getTime() - newYear.getTime() - 
    (this.getTimezoneOffset()-newYear.getTimezoneOffset())*60000)/86400000) + 1;
    var weeknum;
    //if the year starts before the middle of a week
    if(day < 4) {
        weeknum = Math.floor((daynum+day-1)/7) + 1;
        if(weeknum > 52) {
            nYear = new Date(this.getFullYear() + 1,0,1);
            nday = nYear.getDay() - dowOffset;
            nday = nday >= 0 ? nday : nday + 7;
            /*if the next year starts before the middle of
              the week, it is week #1 of that year*/
            weeknum = nday < 4 ? 1 : 53;
        }
    }
    else {
        weeknum = Math.floor((daynum+day-1)/7);
    }
    return weeknum;
};

function drawGraph(period) {
	
	var ctx = document.getElementById('myChart').getContext('2d');
	ctx.canvas.parentNode.style.width = '1000px';
	
	const COLOR_LIST = ['rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)'];
	
	var graphLabelName;
	var graphLabel = new Array();
	var graphSum = new Array;
	var graphDotColor = new Array();
	
	switch(period) {
		case 'day':
			graphLabelName = '일별 매출';
			var cnt = 0;
			var date = dataList[0].date;
			var sumTmp = 0;
			
			dataList.forEach(function(x, i){
				if(date !== x.date)
				{
					graphSum.push( Number( sumTmp.toFixed(12) ) );
					graphLabel.push(date);
					graphDotColor.push(COLOR_LIST[0]);

					date = x.date;
					sumTmp = x.sum;
					cnt++;
				} else {
					sumTmp += x.sum;
				}
			});
			
			graphSum.push( Number( sumTmp.toFixed(12) ) );
			graphLabel.push(date);
			graphDotColor.push(COLOR_LIST[0]);
			break;
		case 'week':
			graphLabelName = '주별 매출';
			
			var sumTmp = 0;
			var beginDay = new Date(dataList[0].date);
			console.log(beginDay);
			beginDay.setDate( beginDay.getDate() - beginDay.getDay() + 1 );
			console.log(beginDay);
			console.log("------------------------------------");
			dataList.forEach(function(x, i){
				var today = new Date(x.date);
				
				if ( today.getWeek() === beginDay.getWeek() ) {
					sumTmp += x.sum;
				} else {
					var endDay = new Date( beginDay );
					endDay.setDate( endDay.getDate() + 6 );
					
					graphSum.push( Number( sumTmp.toFixed(12) ) );
graphLabel.push(`${beginDay.getFullYear()}-${beginDay.getMonth()+1}-${beginDay.getDate()}~${endDay.getFullYear()}-${endDay.getMonth()+1}-${endDay.getDate()}`);					
					graphDotColor.push(COLOR_LIST[1]);
					
					sumTmp = x.sum;
					beginDay= new Date(x.date);
					console.log(beginDay);
					beginDay.setDate( beginDay.getDate() - beginDay.getDay() + 1 );
					console.log(beginDay);
					console.log("------------------------------------");
				}
			});	
			var endDay = new Date( beginDay );
			endDay.setDate( endDay.getDate() + 6 );

			graphSum.push( Number( sumTmp.toFixed(12) ) );
graphLabel.push(`${beginDay.getFullYear()}-${beginDay.getMonth()+1}-${beginDay.getDate()}~${endDay.getFullYear()}-${endDay.getMonth()+1}-${endDay.getDate()}`);
			graphDotColor.push(COLOR_LIST[1]);
			break;
		case 'month':
			graphLabelName = '월별 매출';
			
			var sumTmp = 0;
			var thisMonth = new Date(dataList[0].date).getMonth();
			var cnt = 0;
			
			dataList.forEach(function(x, i){
				var month = new Date(x.date).getMonth();
				
				if(month !== thisMonth){
					graphSum.push( Number( sumTmp.toFixed(12) ) );
					graphLabel.push((thisMonth + 1) + '월');
					graphDotColor.push(COLOR_LIST[2]);
					sumTmp = 0;
					thisMonth = month;
				}
				sumTmp += x.sum;
				
			});
			graphSum.push( Number( sumTmp.toFixed(12) ) );
			graphLabel.push((thisMonth + 1) + '월');
			graphDotColor.push(COLOR_LIST[2]);
			break;
		case 'year':
			graphLabelName = '년별 매출';
			
			var sumTmp = 0;
			var thisYear = new Date(dataList[0].date).getFullYear();
			var cnt = 0;
			
			dataList.forEach(function(x, i){
				var year = new Date(x.date).getFullYear();
				
				if(year !== thisYear){
					graphSum.push( Number( sumTmp.toFixed(12) ) );
					graphLabel.push(thisYear+'년');
					graphDotColor.push(COLOR_LIST[3]);
					sumTmp = 0;
					thisYear = year;
				}
				sumTmp += x.sum;
				
			});
			graphSum.push( Number( sumTmp.toFixed(12) ) );
			graphLabel.push(thisYear+'년');
			graphDotColor.push(COLOR_LIST[3]);
			break;
	}
	

	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: graphLabel,
			datasets: [
				{
					label: `${graphLabelName}`,
					data: graphSum,
					fill: false,
					borderColor: graphDotColor,
					borderWidth: 1,
				},
			],
		},
		options: {
			scales: {
				yAxes: [
					{
						ticks: {
							beginAtZero: true,
						},
						scaleLabel: {
							display: true,
							labelString: '만원',
						},
					},
				],
			},
			elements: {
				line: {
					tension: 0,
				},
			},
		},
	});
}

var DISPLAY_TYPE = 'table';
document.querySelectorAll('.all_result-graph').forEach((x) => x.classList.add('w3-hide'));
document.querySelector('#all_result-table-wrap').classList.remove('w3-hide');

document.querySelector('.switch input').onclick = function () {
	switch (DISPLAY_TYPE) {
		case 'graph':
			document
				.querySelectorAll('.all_result-graph')
				.forEach((x) => x.classList.add('w3-hide'));
			document.querySelector('#all_result-table-wrap').classList.remove('w3-hide');
			DISPLAY_TYPE = 'table';
			break;
		case 'table':
			document
				.querySelectorAll('.all_result-graph')
				.forEach((x) => x.classList.remove('w3-hide'));
			document.querySelector('#all_result-table-wrap').classList.add('w3-hide');
			DISPLAY_TYPE = 'graph';
			break;
	}
};

function show(target) {
	if (target.nodeType === 3) return;
	target.classList.remove('w3-hide');
}

function hide(target) {
	if (target.nodeType === 3) return;
	target.classList.add('w3-hide');
}

var type = 'all';
var beginDate = '2020-01-01';
var endDate = new Date();

function showDropdown(text='전체 선택', id) {
	var x = document.querySelector(`#${id} .w3-dropdown-content`);
	if (x.className.indexOf('w3-show') == -1) {
		x.className += ' w3-show';
	} else {
		x.className = x.className.replace(' w3-show', '');
	}

	if (text !== undefined) {
		document.querySelector(`#${id}`).childNodes[1].innerText = text;
	}
}

function clickHandler(el) {
	const INNER = el.innerText;
	
	const TO_ENG = {
		'전체 선택': 'all',
		'판매': 'sell',
		'충전': 'charge',
		'재고 구매': 'stock',
		
		'일별': 'day',
		'주별': 'week',
		'월별': 'month',
		'년별': 'year'
	};
	
	const DROPDOWN1 = ['전체 선택', '판매', '충전', '재고 구매'];
	const DROPDOWN2 = ['일별', '주별', '월별', '년별'];
	console.log(DROPDOWN1.includes(INNER));
	if(DROPDOWN1.includes(INNER)) {
		type = TO_ENG[INNER];
		showDropdown(INNER, 'type-selector');
		
		document.querySelectorAll("input[type='text']").forEach(function(x) {
			if(x.classList.contains(TO_ENG[INNER])) {
				show(x);
			} else {
				hide(x);
			}
		})
		console.log('DROPDOWN1');
		
	} else if(DROPDOWN2.includes(INNER)){
		showDropdown(INNER, 'period-selector');
		drawGraph(TO_ENG[INNER]);
		console.log('DROPDOWN2');
	}
}

function updateDate() {
	beginDate = new Date(document.querySelectorAll("input[type='date']")[0].value);
	endDate = new Date(document.querySelectorAll("input[type='date']")[1].value);
}


function isIncluded(finding, str) {  /*   두 변수 모두 문자열을 받는다. str에 finding이 포함되어있는지 체크 후 포함하면 true, 포함하지 않으면 false를 반환한다.  */ 
	const expression = new RegExp(finding);
	return expression.test(str);
}

function selectTable() {
	var rowList = document.querySelectorAll('#all_result-table tr.w3-container');
	var headRow = document.querySelectorAll('#all_result-table-head td');
	var colorRow = 0;
	dataList = [];
	
	updateDate();

	headRow.forEach(function (cell, index) {
		if (cell.classList.contains(type) || index < 4) {
			show(cell);
		} else {
			hide(cell);
		}
	});

	rowList.forEach(function (row) {
		/* 각 열마다 조건을 체크 */
		var TYPE_OK; /*  유형 체크  */
		var DATE_OK; /*  날짜 체크  */
		var SELLER_OK = true; /* 승인자 체크 */
		var CONSUMER_OK = true; /* 소비자 체크 */
		var PRODUCT_OK = true; /* 상품명 체크 */

		if (type === 'all') {
			TYPE_OK = true; /* 유형이 전체선택이면 true */
		} else {
			TYPE_OK = row.classList.contains(type); /* 아니면 class체크 */
		}

		var rowDate = new Date(row.querySelector('.date').innerText);
		if (beginDate.getTime() <= rowDate.getTime() && rowDate.getTime() <= endDate.getTime()) {
			/* beginDate <= rowDate <= endDate */
			DATE_OK = true;
		} else {
			DATE_OK = false;
		}
		
		var findingSeller = document.querySelector("#search-seller").value;
		if(findingSeller) {
			SELLER_OK = false;
			row.childNodes.forEach(function(cell) {
				if ( cell.nodeType === 1 ) {
					if ( (isIncluded(findingSeller, cell.innerText)) && (cell.classList.contains('seller')) ) {
						SELLER_OK = true;
					}
				}
			});
		}
		
		var findingConsumer = document.querySelector("#search-consumer").value;
		if(findingConsumer) {
			CONSUMER_OK = false;
			row.childNodes.forEach(function(cell) {
				if ( cell.nodeType === 1 ) {
					if ( (isIncluded(findingConsumer, cell.innerText)) && (cell.classList.contains('consumer')) ) {
						CONSUMER_OK = true;
					}
				}
			});
		}
		
		var findingProduct = document.querySelector("#search-product").value;
		if(findingProduct) {
			PRODUCT_OK = false;
			row.childNodes.forEach(function(cell) {
				if ( cell.nodeType === 1 ) {
					if ( (isIncluded(findingProduct, cell.innerText)) && (cell.classList.contains('product')) ) {
						PRODUCT_OK = true;
					}
				}
			});
		}

		if (TYPE_OK && DATE_OK && SELLER_OK && CONSUMER_OK && PRODUCT_OK) {
			row.childNodes.forEach((cell) => show(cell));
			show(row);
			
			if (colorRow%2 === 0) {
				row.classList.add('table-impact');
			} else {
				row.classList.remove('table-impact');
			}
			colorRow++;
			
			var record = {
				sum: Number(row.childNodes[5].innerText) / 10000,
				date: row.childNodes[3].innerText
			};
			dataList.unshift(record);
		} else {
			hide(row);
		}
	});
	

	if (type === 'all') {
		/* 모든 기록을 보여줄 때는 기록 유형마다 갖는 column이 달라서 공통되는 column외의 다른 column들을 숨겨주는 작업 */
		const SHOW_LIST = ['type', 'date', 'sum', 'seller'];
		rowList.forEach(function (row) {
			row.childNodes.forEach(function (cell) {
				if (cell.nodeType === 3) return;
				if (SHOW_LIST.includes(cell.classList[2])) show(cell);
				else hide(cell);
			});
		});
	}
}

function init() {
	var dateInput = document.querySelectorAll("input[type='date']");
	dateInput[0].value = beginDate;
	dateInput[1].valueAsDate = endDate;

	beginDate = new Date(beginDate);

	setInterval(selectTable, 250);
	selectTable();
	drawGraph('day');
}

init();
/*

검색 기능 넣을 것

- 날짜 범위 설정 O
- 상품 별 설정
- 책임자(seller) 설정
- 구매자(consumer) 설정 (기록이 sell, charge일때만)
- 기록 종류(sell, charge, stock) 설정 O

*/
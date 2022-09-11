let DATA_TYPE = '전체선택';

function AddComma(dataValue) {
  //isNumber(dataValue);
  var separateValue = Number(dataValue).toLocaleString('en');
  if (separateValue == 'NaN') {
    return '';
  }
  return separateValue;
}

function searchAllResult() {
	let searchInfo = document.querySelectorAll("input.all_result-searchInfo");
	let formInput = document.querySelectorAll("form input[type='hidden']");
	
	setEndDateToBegin({target: document.querySelector("input[type='checkbox']")});
	
	formInput[0].value = DATA_TYPE;
	
	searchInfo.forEach(function(x, i) {
		if(i == 5) return;
		
		if(x.value == '') {
			formInput[i + 1].value = '';
		} else {
			formInput[i + 1].value = x.value;
		}
	});
	
	let chargeTypes = document.querySelectorAll('label[data-charge-type]');
	
	formInput[6].value = "";
	
	chargeTypes.forEach(function(x, i) {
		if(i == 0) return;
		if(x.classList.contains('w3-gray')) {
			formInput[6].value += x.dataset.chargeType + ",";
		}
	})
	
	document.querySelector('form').submit();
}

function displayTableHead() {
	
	const KorToEng = {
		전체선택: "all", 
		판매: 'sell',
		충전: 'charge',
		재고구매: 'stock'
	};
	
	document.querySelectorAll("#all_result-table-head>td").forEach(function(x) {
			
		if(x.classList.contains(KorToEng[DATA_TYPE])) {
			x.classList.remove('w3-hide');
		} else {
			x.classList.add('w3-hide');
		}

	});
}

function displaySelector() {
	
	const KorToEng = {
		전체선택: "all", 
		판매: 'sell',
		충전: 'charge',
		재고구매: 'stock'
	};
	
	document.querySelectorAll(".all_result-data-type-hide-show").forEach(function(x) {
			
		if(x.classList.contains(KorToEng[DATA_TYPE])) {
			x.classList.remove('w3-hide');
		} else {
			x.classList.add('w3-hide');
		}

	});
}

function clickHandler(event) {
	let target = event.target;
	
	if(target.type == 'button') {
		searchAllResult();
	} else if(target.hasAttribute('data-charge-type')) {
		
		if(target.dataset.chargeType == "all") {
			
			let code;
			
			if(target.classList.toggle('w3-gray')) {
				code = "x.classList.add('w3-gray')";
			} else {
				code = "x.classList.remove('w3-gray')";
			}
			
			document.querySelectorAll('label[data-charge-type]').forEach(function(x){
				eval(code);
			});
			
		} else {
			
			target.classList.toggle('w3-gray');
			
		}
		
	} else {
	
		DATA_TYPE = target.innerText;

		document.querySelector("#all_result-data-type-selector").children[0].innerText = target.innerText;
		
		displaySelector();
	}
}

function handleMoney(nodeList) {
	nodeList.forEach(function(x) {
		x.innerText = AddComma(x.innerText) + "원";
	});
}

function getAllSum() {
	let moneyList = document.querySelectorAll('.all_result-table-column-money');
	let sum = 0;
	
	if(moneyList.length > 0) {
		moneyList.forEach(function(x) {
			sum += Number(x.innerText);
		});
	}
	return sum;
}

function setEndDateToBegin(event) {
	let target = event.target;
	let dateList = document.querySelectorAll("input[type='date']");
	
	if(target.checked){
		dateList[1].parentNode.classList.add('w3-hide');
		dateList[1].value = dateList[0].value;
	} else {
		dateList[1].parentNode.classList.remove('w3-hide');
	}
}
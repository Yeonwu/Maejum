var interval;

function isIncluded(finding, str) {
	const expression = new RegExp(finding);
	return expression.test(str);
}

function getTextVal() {
	return document.querySelector('#charge-searchTxt').value;
}

function updateDisplay() {
	const TYPE_EL = 1;
	const HEAD_INDEX = 1;
	var rowList = document.querySelector('#charge-table tbody');
	var rowIndex, cellIndex;
	var nth = 1;

	if (rowList === null) {
		clearInterval(interval);
		return;
	}

	rowList = rowList.childNodes;

	for (rowIndex = 0; rowIndex < rowList.length; rowIndex++) {
		if (rowList[rowIndex].nodeType === TYPE_EL) {
			const cellList = rowList[rowIndex].childNodes;
			var cellStr = ' ';

			for (cellIndex = 0; cellIndex < cellList.length; cellIndex++) {
				if (cellList[cellIndex].nodeType === TYPE_EL) {
					cellStr += cellList[cellIndex].innerText;
				}
			}

			if (isIncluded(getTextVal(), cellStr)) {
				rowList[rowIndex].classList.remove('w3-hide');
				if (nth%2) {
					rowList[rowIndex].classList.add('table-impact');
				} else {
					rowList[rowIndex].classList.remove('table-impact');
				}
				nth++;
			} else {
				rowList[rowIndex].classList.add('w3-hide');
			}
		}
	}
}


interval = setInterval(updateDisplay, 1);


function submitToChargeCheck(event){
	var row = event.target.parentNode.parentNode;
	console.log(row);
	var grade = row.childNodes[1].innerText;
	var name = row.childNodes[2].innerText;
	var email = row.childNodes[3].innerText;
	
	var inputs = document.querySelectorAll("form input");
	inputs[0].value = grade;
	inputs[1].value = name;
	inputs[2].value = email;
	
	inputs[3].parentNode.submit();
}

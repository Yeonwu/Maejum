var dataForSend = new Array();

function productTypeChange(event) {
	var id = event.target.href;
	var buttons = document.querySelectorAll('#choose_type a');
	buttons.forEach(function (btn) {
		if (btn.href !== id) {
			btn.classList.remove('w3-gray');
		} else {
			btn.classList.add('w3-gray');
		}
	});
}

function updateSum() {
	const priceList = document.querySelectorAll('#buy_info_container .product-price');
	const numList = document.querySelectorAll('#buy_info_container .product-num');
	const sumEl = document.querySelector('#sell-list-sum');
	var sum = 0;
	
	for(var i = 0; i < numList.length; i++) {
		var price = Number(priceList[i].innerText.slice(0,-1));
		var num = Number(numList[i].value);
		dataForSend[i].num = num;
		sum += (price * num);
	}
	
	sumEl.innerText = sum + '원';
}

function adjustHeight() {
	let height = dataForSend.length * 64 + 200;
	document.querySelector("#buy_info").style.height = height + "px";
	height += 100;
	document.querySelector(".sell_grid.last").style.marginBottom = height + "px";
}

function addSellList(event) {
	const product_nm = event.target.parentNode.nextSibling.nextSibling.innerText;
	const product_price = event.target.parentNode.nextSibling.nextSibling.nextSibling.nextSibling.innerText;
	const sellList = document.querySelector('#buy_info_container');
	const nameList = document.querySelectorAll('#buy_info_container .product-name');
	const numList = document.querySelectorAll("#buy_info_container .product-num");
	var ALREADY_ADDED = false;
	
	nameList.forEach(function(x, index) {
		if( x.innerText === product_nm ){
			ALREADY_ADDED = true;
			numList[index].value++;
			dataForSend[index].num++;
			updateSum();
		}
	})
	
	if(ALREADY_ADDED) return;
	
	var added = document.createElement('tr');
	added.innerHTML = `<td class="product-name">` + product_nm + `</td>
					   <td><input class="product-num" type="number" value="1" min=0 onchange="updateSum()"</td>
					   <td class="product-price">` + product_price + `</td>
					   <td><div class="w3-button center-container w3-red hover-active w3-round" style="width: 35px; height: 35px;" onclick="removeSellList(event)"><i class="las la-times"></i></div></td>`;
	
	sellList.appendChild(added);
	
	dataForSend.push({
		name: product_nm,
		price: product_price,
		num: 1,
	});
	
	adjustHeight();
	updateSum();
}

function removeSellList(event) {
	const removed = event.target.parentNode.parentNode;
	const sellList = document.querySelector('#buy_info_container');
	
	dataForSend = dataForSend.filter(function(x) {
    	return x.name !== removed.querySelector(".product-name").innerText;
	});
	
	adjustHeight();
	sellList.removeChild(removed);
	
	updateSum();
}

function submitSell() {
	const form = document.querySelector("form");
	const jsonInput = document.querySelector("input[name='json_data']");
	const lenInput = document.querySelector("input[name='length']");
	
	jsonInput.value = JSON.stringify(dataForSend);
	lenInput.value = dataForSend.length;
	form.submit();
}
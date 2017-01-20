<!DOCTYPE html>
<html>
<head>
	<title>Calculator</title>
</head>
<body>
<div >एउटा रकम<input id="calc_value1" type="text"> <button onclick="paste_res('calc_value1')">उत्तर</button></div>
<div >अर्को रकम<input id="calc_value2" type="text"><button onclick="paste_res('calc_value2')">उत्तर</button></div>
<div>Result (उत्तर):<p id="calc_result"></p></div>
<button onclick="add();">Add</button>&nbsp;&nbsp;
<button onclick="subtract();">Subtract</button>&nbsp;&nbsp;
<button onclick="multiply();">Multiply</button>&nbsp;&nbsp;
<button onclick="divide();">Divide</button>&nbsp;&nbsp;
<script type="text/javascript">
function paste_res(value){
	document.getElementById(value).value = document.getElementById("calc_result").innerHTML;
}

	function add () {
		document.getElementById("calc_result").innerHTML = parseFloat(document.getElementById("calc_value1").value) + parseFloat(document.getElementById("calc_value2").value);
	}
	function subtract () {
		document.getElementById("calc_result").innerHTML = parseFloat(document.getElementById("calc_value1").value) - parseFloat(document.getElementById("calc_value2").value);
	}
	function multiply () {
		document.getElementById("calc_result").innerHTML = parseFloat(document.getElementById("calc_value1").value) * parseFloat(document.getElementById("calc_value2").value);
	}
	function divide () {
		document.getElementById("calc_result").innerHTML = parseFloat(document.getElementById("calc_value1").value) / parseFloat(document.getElementById("calc_value2").value);
	}
</script>
</body>
</html>
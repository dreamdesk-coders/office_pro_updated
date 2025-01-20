var pur_dec = getCookie("purchase_decimal");
var step_string = getCookie("purchase_step");
function sum_amounts() {


  var paid_amount = parseFloat(document.getElementById("paid_amount").value);
  var discount = parseFloat(document.getElementById("discount").value);
  var discount_percent = parseFloat(document.getElementById("discount_percent").value);
  var tax = parseFloat(document.getElementById("tax").value);
  var expense = parseFloat(document.getElementById("expense").value);
  var total_amount = parseFloat(document.getElementById("total_amount").value);
  var grand_total = parseFloat(document.getElementById("grand_total").value);
  var net_amount = parseFloat(document.getElementById("net_amount").value);

  if (paid_amount == 0 || paid_amount == null) {

      paid_amount = 0;

  } else if (paid_amount < 0) {

      alert_("Info", "Paid amount cannot be less than 0.");
      localStorage.setItem("focus", "paid_amount");
      paid_amount = 0;
      $("#paid_amount").focus().val("");

  } else if (!$.isNumeric($('#paid_amount').val())) {

      alert_("Info", "Only numeric characters are allowed.");
      localStorage.setItem("focus", "paid_amount");
      paid_amount = 0;
      $("#paid_amount").focus().val("");

  }

  if (discount == 0 || discount == null) {

      discount = 0;

  } else if (discount < 0) {

      alert_("Info", "Discount amount cannot be less than 0.");
      localStorage.setItem("focus", "discount");
      discount = 0;
      $("#discount").focus().val(0);

  } else if (discount > total_amount) {

      alert_("Info", "Discount amount cannot be greater than total amount.");
      localStorage.setItem("focus", "discount");
      discount = 0;
      $("#discount").focus().val(0);
      $("#discount_percent").focus().val(0);

  } else if (!$.isNumeric($('#discount').val())) {

      alert_("Info", "Only numeric characters are allowed.");
      localStorage.setItem("focus", "discount");
      discount = 0;
      $("#discount").focus().val(0);

  }

  if (discount_percent == 0 || discount_percent == null) {

      discount_percent = 0;

  } else if (discount_percent < 0) {

      alert_("Info", "Discount percent cannot be less than 0.");
      localStorage.setItem("focus", "discount");
      discount_percent = 0;
      $("#discount_percent").focus().val(0);

  } else if (discount_percent > 100) {

      alert_("Info", "Discount percent cannot be greater than 100.");
      localStorage.setItem("focus", "discount");
      discount_percent = 0;
      $("#discount_percent").focus().val(0);
      $("#discount").focus().val(0);

  } else if (!$.isNumeric($('#discount_percent').val())) {

      alert_("Info", "Only numeric characters are allowed.");
      localStorage.setItem("focus", "discount_percent");
      discount_percent = 0;
      $("#discount_percent").focus().val(0);

  }

  if (tax == 0 || tax == null) {

      tax = 0;

  } else if (tax < 0) {

      alert_("Info", "Tax amount cannot be less than 0.");
      localStorage.setItem("focus", "tax");
      tax = 0;
      $("#tax").focus().val("");

  } else if (!$.isNumeric($('#tax').val())) {

      alert_("Info", "Only numeric characters are allowed.");
      localStorage.setItem("focus", "tax");
      tax = 0;
      $("#tax").focus().val("");

  }

  if (expense == 0 || expense == null) {

      expense = 0;

  } else if (expense < 0) {

      alert_("Info", "Expense Amount Cannot be less than 0.");
      localStorage.setItem("focus", "expense");
      expense = 0;
      $("#expense").focus().val("");

  } else if (!$.isNumeric($('#expense').val())) {

      alert_("Info", "Only numeric characters are allowed.");
      localStorage.setItem("focus", "expense");
      expense = 0;
      $("#expense").focus().val("");

  }

  if (net_amount == 0 || net_amount == null) {

      net_amount = 0;

  }


  grand_total = parseFloat(total_amount) + parseFloat(tax) + parseFloat(expense) - parseFloat(discount);
  

  document.getElementById("grand_total").value = grand_total.toFixed(pur_dec);

  if (paid_amount > grand_total) {

      alert_("Info", "Paid amount cannot be greater than total amount.");
      localStorage.setItem("focus", "paid_amount");
      paid_amount = 0;
      $("#paid_amount").focus().val("");

  }

  net_amount = parseFloat(grand_total) - parseFloat(paid_amount);

  // $('#net_amount').val(net_amount);
  document.getElementById("net_amount").value = net_amount.toFixed(pur_dec);
}

/** function to calculate discount */
function discount_() {
  var discount = parseFloat(document.getElementById("discount").value);
  var discount_percent = (document.getElementById("discount_percent").value);
  var total_amount = (document.getElementById("total_amount").value);


  if (discount_percent >= 0 && discount_percent <= 100) {
      discount = (total_amount * ((discount_percent) / 100)).toFixed(pur_dec);
      $("#discount").val(discount);
  }


}
/** function to calculate discount percent */
function discount_percent_() {

  var discount = parseFloat(document.getElementById("discount").value);
  var discount_percent = parseFloat(document.getElementById("discount_percent").value);
  var total_amount = parseFloat(document.getElementById("total_amount").value);

  if (discount >= 0 && discount <= total_amount) {

      discount_percent = ((discount / total_amount) * 100).toFixed(pur_dec);
      $("#discount_percent").val(discount_percent);

  } else {
      discount = 0;

  }

}

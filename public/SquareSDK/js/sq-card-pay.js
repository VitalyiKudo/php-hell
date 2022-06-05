async function CardPay(fieldEl, buttonEl) {
  // Create a card payment object and attach to page
  const card = await window.payments.card({

  });
  await card.attach(fieldEl);

  async function eventHandler(event) {
    //event.preventDefault();
    console.log('Отправка!');
    // Clear any existing messages
    window.paymentFlowMessageEl.innerText = '';
      //alert(document.getElementById('card-nonce').value);
    try {
      const result = await card.tokenize();
        //alert(document.getElementById('card-nonce').value);
        //alert(result.token);
      if (result.status === 'OK') {
          //$('#card-nonce').val(result.token);
          document.getElementById('card-nonce').setAttribute('value', result.token);
          //alert(document.getElementById('card-nonce').value);
          //alert(result.token);
          document.forms['nonce-form'].submit();
          //#document.getElementById('nonce-form').submit();
         return false;
        // Use global method from sq-payment-flow.js
        window.createPayment(result.token);
      }
    } catch (e) {
      if (e.message) {
        window.showError(`Error: ${e.message}`);
      } else {
        window.showError('Something went wrong');
      }
    }
  }

  buttonEl.addEventListener('click', eventHandler);
}

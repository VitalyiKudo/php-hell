async function CardPay(fieldEl, buttonEl) {
  // Create a card payment object and attach to page
  const card = await window.payments.card({

  });
  await card.attach(fieldEl);

  async function eventHandler(event) {

    console.log('Отправка!');
    // Clear any existing messages
    window.paymentFlowMessageEl.innerText = '';

    try {
      const result = await card.tokenize();
      if (result.status === 'OK') {
          document.getElementById('card-nonce').setAttribute('value', result.token);
          document.forms['nonce-form'].submit();

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

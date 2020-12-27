@include('layouts.header')
<style type="text/css">

  /**
  * The CSS shown here will not be introduced in the Quickstart guide, but
  * shows how you can use CSS to style your Element's container.
  */
  body
  {
    display: flex;
    align-items: center;
    justify-content: center;

    height: 100vh;
  }
  div#main-wrapper {
    width: 50%;
    margin: auto;
    background: white;
    padding: 50px;
    box-shadow: 0 0 41px 0px #00000026;
  }
  input,
  .StripeElement {
    height: 45px;
    padding: 10px 12px;
    width: 100%;
    color: #32325d;
    background-color: white;
    border:1px solid #00a2ce;
    border-radius: 4px;
    box-shadow: 0 4px 11px 0 #e6ebf1ba;
    -webkit-transition: box-shadow 150ms ease;
    margin-bottom: 20px;
    transition: box-shadow 150ms ease;
  }
  button#card-button {
    background: #00a2ce;
    border:  1px solid #00a2ce;
    width: 50%;
    margin: auto;
    display: table;
    margin-top: 50px;
    padding: 15px;
    color: #fff;
    box-shadow: 0 8px 17px 0px #00a2ce3d;
    transition: .3s ease all;
  }
  button#card-button:hover
  {
    background:transparent;
    border:  1px solid #00a2ce;
    color: #00a2ce;
  }
  input:focus,
  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }

  .StripeElement--invalid {
    border-color: #fa755a;
  }

  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
  h1 {
    font-weight: 400;
    font-size: 22px;
    text-align: center;
    position: relative;
    /* color: red; */
    margin-bottom: 45px;
  }

  h1:before {content: "";position: absolute;display: block;width: 40px;height: 3px;background: #00a2ce;margin: auto;left: 0;right: 0;bottom: 0px;}
  input#checkbox {
    height: initial;
    box-shadow: none;
    text-align: left;
    width: initial;
    margin-right: 10px;
    margin-left: 1px;
  }
</style>
<h1>
  Payment Details
</h1>
<input id="card-holder-name" type="text" placeholder="Card holder Name">

<!-- Stripe Elements Placeholder -->
<div id="card-element"></div>

<label for="checkbox"><input type="checkbox" name="termsAndCondition" id="checkbox" />Agree to the automatic payment subscription every period</label>




<button id="card-button" data-secret="{{ $intent->client_secret }}">
  <input type="hidden" name="planId" value="{{$planId}}">
  <input type="hidden" name="planName" value="{{$planName}}">

  Update Payment Method
</button>
@include('layouts.footer')

<script src="//js.stripe.com/v3/"></script>

<script>
  const stripe = Stripe('{{env("STRIPE_KEY")}}');
  var style = {
    base: {
      color: '#32325d',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#aab7c4'
      }
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  };
  const elements = stripe.elements();
  const cardElement = elements.create('card',{style: style});


  cardElement.mount('#card-element');

  const cardHolderName = document.getElementById('card-holder-name');
  const cardButton = document.getElementById('card-button');
  const clientSecret = cardButton.dataset.secret;

  cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
      clientSecret, {
        payment_method: {
          card: cardElement,
          billing_details: { name: cardHolderName.value }
        }
      }
    );

    if (error) {
      alert(error.message);
      // Display "error.message" to the user...
    } else {
      if($("#checkbox").is(":checked"))
      {
        console.log(setupIntent.payment_method);
        url="{{route('add.subscription')}}";
        $.ajax({
          type: "POST",
          url: url,
          data: {
            "planName":$("input[name='planId']").val(),"paymentMethod": setupIntent.payment_method,"_token":"{{csrf_token()}}"
          },
          success: function(data) {
            swalWithBootstrapButtons.fire(
              'Success!!',
              'You have successfully subscribed to ',
              'success'
            )
            window.location.replace("{{route('index')}}");
          },
          error: function(xhr, textStatus, error){
            swalWithBootstrapButtons.fire(
              'Error!!',
              JSON.parse(xhr.responseText).message,
              'error'
            )
          }
        });

        alert('The card has been verified successfully...');
      }
      else
      {
        swalWithBootstrapButtons.fire(
          'Error!!',
          'Agree to the recurring payment',
          'error'
        )
      }

    }
  });
</script>

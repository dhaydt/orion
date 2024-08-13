<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Print Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  :root {
    --font-color: #434343;
    --badge-color: #F34EF3;
    --secondary-color: #bfbfbf;
    --font-secondary-color: #818181;
    --bg-color-dark: #222121;
  }

  body {
    font-family: 'Poppins', sans-serif;
  }

  div:where(.swal2-container) div:where(.swal2-popup) {
    width: 20em !important;
    max-width: 30em !important;
    padding: 0 0 0.25em;
  }

  div:where(.swal2-icon) {
    width: 5em !important;
    height: 5em !important;
    margin: 0.5em auto 0.6em !important;
  }

  div:where(.swal2-container) h2:where(.swal2-title) {
    padding: 0.1em 0 0 !important;
    font-size: 1.275em !important;
  }

  div:where(.swal2-container) .swal2-html-container {
    margin: 2px 0 !important;
  }

  div:where(.swal2-container) div:where(.swal2-actions) {
    margin: 0.25em auto 0 !important;
  }

  @media(max-width: 590px) {
    body {
      width: 100vw;
      max-width: 100vw;
      overflow-x: hidden;
    }
  }

  a {
    text-decoration: none !important;
    color: unset !important;
  }

  .home-btn {
    margin-top: auto;
    margin-bottom: auto;
  }

  .mt-2 {
    margin-top: 5px;
  }

  /* cashier */
  .title-gray {
    color: #454444;
    font-size: 20px;
    font-weight: 500;
  }

  .subtitle-gray {
    color: #454444;
    font-size: 16px;
    font-weight: 400;
  }

  .main-container {
    /* background-color: #bbb; */
    min-height: 100vh;
    max-width: 590px;
    padding-left: 0;
    padding-right: 0;
  }

  .nav-header {
    height: 55px;
    /* border: 1px solid #000; */
    position: absolute;
    max-width: 590px;
    min-width: 590px;
    top: 0;
    margin-left: auto;
    margin-right: auto;
  }

  .search-nav {
    width: 75%;
  }

  .card-tool {
    width: 25%;
  }

  .card-tool a {
    font-size: 22px;
    color: var(--font-color);
    text-decoration: none;
  }

  .counter-anchor .counter {
    position: absolute;
    font-size: 14px;
    background: var(--badge-color);
    padding: 1px 8px;
    border-radius: 50%;
    font-weight: 700;
    color: #fff;
    top: -2px;
    right: -8px;
  }

  .search-nav .form-floating,
  .search-nav .form-floating input {
    height: 40px;
  }

  .search-nav .input-group-text {
    border-radius: 50px 0 0 50px;
    background-color: transparent;
    color: #999;
    border-right: unset !important;
  }

  .search-nav input {
    border-left: unset;
    border-radius: 0 50px 50px 0;
  }

  .content-wrapper {
    margin-top: 55px;
  }

  @media(max-width: 600px) {
    .nav-header {
      height: 55px;
      /* border: 1px solid #000; */
      max-width: unset;
      min-width: unset;
      position: absolute;
      left: 0;
      right: 0;
    }

    .main-container {
      max-width: 100vw;
    }
  }

  /* category-section */

  .category-wrapper {
    border-radius: 50%;
    overflow: hidden;
    height: auto;
    width: 100%;
  }

  .category-wrapper img {
    min-height: 100%;
  }

  .item-category a {
    text-decoration: none;
    color: inherit;
  }

  .category-name {
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
  }

  .carousel-category .owl-theme .owl-nav.disabled+.owl-dots {
    margin-top: 5px;
  }

  .carousel-category .owl-theme .owl-dots,
  .owl-theme .owl-nav {
    text-align: center;
  }

  .carousel-category .owl-theme .owl-dots .owl-dot span {
    margin: 5px 4px;
  }

  /* Catgeory food item */
  .card.item-category-card {
    border-radius: 20px;
    border: 1px solid #b2b2b2;
    text-decoration: none;
    color: unset;
  }

  .card-category-wrapper {
    height: 170px;
    border-radius: 20px 20px 0 0;
    overflow: hidden;
  }

  .food-name {
    font-size: 14px;
    text-transform: capitalize;
    font-weight: 600;
    line-height: 1.3;
  }

  .food-price {
    font-size: 14px;
    text-transform: capitalize;
    font-weight: 600;
  }

  .carousel-foods .owl-stage-outer {
    padding-bottom: 10px;
  }

  .card-category-description {
    height: 90px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  /* page welocme */
  .page-welcome {
    height: 80vh;
    align-items: center;
    padding-top: 15vh
  }

  .page-welcome .page-content {
    padding-top: 15vh;
  }

  .page-content h6 {
    margin-right: 46vw;
    color: var(--font-secondary-color)
  }

  .card-single {
    padding: 15px 30px;
    border-radius: 20px;
    border: 2px solid #bfbfbf;
  }

  .page-content .card-single {
    text-decoration: none;
    color: unset;
  }

  .page-content .card-single .icon-title {
    font-size: 16px;
    margin-top: 10px;
    font-weight: 500;
  }

  .back-btn {
    color: var(--font-color);
    font-size: 18px;
  }

  .header-title .title {
    color: var(--font-secondary-color);
    font-weight: 600;
  }

  .user-information select.form-control {
    font-size: 12px !important;
    background-color: #dfdfdf !important;
  }

  .user-information select.form-control option {
    font-size: 12px !important;
    background-color: #dfdfdf !important;
  }

  /* page detail */

  .detail-wrapper {
    margin-left: -12px;
    margin-right: -12px;
  }

  .font-description {
    text-transform: capitalize;
    font-size: 14px;
    font-weight: 500
  }

  .font-title {
    font-size: 16px;
    font-weight: 600;
  }

  .font-content {
    font-size: 12px;
  }

  .qty-input.input-group {
    width: unset;
  }

  .qty-input .btn.btn-secondary {
    background-color: var(--bg-color-dark);
    border-radius: 50%;
  }

  .qty-input input.form-control {
    border: unset;
    text-align: center;
    width: 50px;
  }

  .qty-input.input-group .form-control {
    flex: unset;
  }

  .extra-food {
    border: 1px solid var(--font-secondary-color);
    border-radius: 15px;
  }

  .extra-list label {
    font-size: 14px;
    text-transform: capitalize
  }

  .add-cart-session {
    position: absolute;
    bottom: 10px;
    left: 0;
    max-width: 590px;

  }

  .add-cart-wrapper {
    background-color: var(--bg-color-dark);
    border-radius: 15px;
  }

  /* Cart detail */
  .item-cart {
    border-bottom: 2px solid #F0F0F0;
  }

  .font-description.cart-font {
    color: #838383;
    font-size: 12px;
  }

  .btn-delete {
    text-decoration: none;
    color: #000;
    font-size: 12px;
    font-weight: 600;
  }

  .label-title {
    font-size: 12px;
    font-weight: 500;
  }

  .note-wrapper {
    border: 2px solid #dfdfdf;
    margin: 10px;
    border-radius: 14px;
  }

  .note-text {
    font-size: 12px;
  }

  .note-wrapper .form-control {
    border: unset;
    font-size: 12px;
  }

  .border-line {
    border: 1px solid #dfdfdf;
  }

  .add-item-btn {
    width: 100%;
    border: 1px solid var(--badge-color);
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    padding: 10px;
    color: var(--badge-color);
  }

  .baris-harga {
    font-size: 12px;
    margin-top: 5px;
  }

  /* next button */
  .next-wrapper {}

  .next-btn.text-dark {
    color: #000 !important;
  }

  .next-btn {
    background: #222121;
    border-radius: 7px;
    color: #fff !important;
    text-decoration: none;
    font-weight: 500;
    width: 100%;
    text-align: center;
    padding: 10px 5px;
  }

  /* Paymnet pages */
  .nav-pages {
    border-bottom: 2px solid #dfdfdf;
  }

  .user-information input.form-control {
    font-size: 12px;
    background-color: #dfdfdf;
  }

  /* payment method */
  .payment-method {
    min-height: 92vh;
  }

  .payment-information .form-check {
    /* background-color: #dfdfdf; */
    /* border-radius: 6px; */
    padding: 0px 15px;
    font-size: 14px;
  }

  .payment-information .form-check .form-check-input {
    float: right;
  }

  .next-wrapper.confirm-btn {
    position: absolute;
    bottom: 0;
    width: 100%;
  }

  #modalConfirm .modal-dialog {
    margin-bottom: 16rem;
  }

  #modalConfirm .modal-content {
    border-radius: 15px;
  }

  #modalConfirm .modal-content .btn {
    font-size: 12px;
  }

  #modalConfirm .modal-content .btn-yes {
    background-color: #000;
    border: 1px solid #000;
    ;
    color: #fff;
    transition: .2s;
  }

  #modalConfirm .modal-content .btn-yes:hover {
    background-color: #fff;
    border: 1px solid var(--badge-color);
    color: var(--badge-color);
  }

  /* order-success */
  .order-success {
    min-height: 80vh;
  }

  .check-logo {
    font-size: 70px;
    border: 1px solid #333232;
    border-radius: 50%;
    padding: 5px 27px;
    color: #fff;
    background: #333232;
    margin-top: 20px;
  }

  .next-wrapper.order-again .next-btn {
    background: #fff;
    border: 1px solid #000;
    color: #000;
  }

  .border-line.dashed {
    border: 1px dashed #dfdfdf;
  }

  /* detail order */
  .badge.payment-status {
    padding: 3px 10px;
    font-size: 12px;
    border-radius: 4px;
  }

  /* Bill */
  .bill-card {
    border: 1px solid #a9a9a9;
    border-radius: 9px;
  }

  a.bill-card {
    text-decoration: none;
    color: unset;
  }

  .payment-information .form-check.bg-lights {
    background-color: #fff !important;
    border: 1px solid #dfdfdf;
    border-radius: 4px;
  }

  /* category cashier */
  .card-single.card-category {
    width: 130px;
    height: 130px;
  }

  .page-content .card-single.card-category .icon-title {
    font-size: 12px;
    text-align: center;
  }

  .icon-wrapper .icon {
    font-size: 30px;
    padding: 5px 15px;
    border-radius: 50%;
  }

  .counter-bill {
    top: -10px;
    right: -6px;
  }

  .counter-bill span.bg-in {
    background: #37C306;
    color: #fff;
    border-radius: 50%;
  }

  .counter-bill span.bg-out {
    background: #F40909;
    color: #fff;
    border-radius: 50%;
  }

  /* New Order */
  .card-order {
    border: 1px solid #575656;
    border-radius: 20px;
    font-size: 14px;
    text-decoration: none;
  }

  .bg-blue {
    background: #99DDFA !important;
  }

  .bg-yellow {
    background: #FFCF73 !important;
  }

  .card-order.bg-grey {
    background: #c3c3c3 !important;
  }

  .card-order.bg-red {
    background: #fb6d6d !important;
  }

  .close-all.bg-red {
    background: #fb6d6d !important;
    width: 100%;
    display: flex;
    text-align: center;
    justify-content: center;
    margin-bottom: 30px !important;
  }

  .position-relative {
    position: relative;
  }

  .position-relative .close-btn {
    position: absolute;
    right: -5px;
    top: -11px;
    padding: 1px 6px;
    border: 1px solid #ff4b4b;
    border-radius: 50px;
    background: #ff4b4b;
    color: #fff;
  }

  .loading-wrapper {
    position: absolute;
    top: 45%;
    left: 48%;
    height: 60px;
  }

  .hide {
    display: none;
  }

  .description-category .text-content {
    font-size: 14px;
    color: #393939;
    font-weight: 500;
  }

  .description-category .text-price {
    font-size: 14px;
    font-weight: 600;
    color: #393939;
  }

  .description-category .text-btn {
    background: #000;
    color: #fff;
    padding: 3px 13px;
    border-radius: 6px;
    font-size: 14px;
    line-height: 1.6;
  }

</style>
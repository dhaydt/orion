<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/sweetalert11.js') }}"></script>
  <script src="{{ asset('assets/custom.js') }}"></script>
<script>
  $(document).ready(function(){
      hideLoading()
    });

    function showLoading(){
      $('.loading-wrapper').removeClass('hide');
    }
    
    function hideLoading(){
      $('.loading-wrapper').addClass('hide');
    }
</script>
@livewireScripts()
@stack('js')
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel1">Message Customer</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <form>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Name:</label>
                  <input type="text" class="form-control" id="recipient-name1">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Phone:</label>
                  <input type="text" class="form-control" id="recipient-name1">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Message</label>
                  <textarea class="form-control"></textarea>
               </div>

            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-info">Send</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel1">Add Users</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
           <form method="post" action="{{route('user.store')}}" id="userForm">
         <div class="modal-body">

              @csrf
              <div class="form-group">
                  <label for="recipient-name" class="control-label">Business Name:</label>
                  <input type="text" class="form-control" id="recipient-name1" name="business_name">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Name:</label>
                  <input type="text" class="form-control" id="recipient-name1" name="name">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Email:</label>
                  <input type="email" class="form-control" id="recipient-name1" name="email">
               </div>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">Phone:</label>
                  <input type="text" class="form-control" id="recipient-name1" name="phone">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Password:</label>
                  <input type="password" class="form-control" id="recipient-name1" name="password">
               </div>
                <div class="form-group">
                  <label for="recipient-name" class="control-label">Payment Type:</label>
                  <select class="form-control" name="payment_type">
                    <option value="stripe">Stripe</option>
                    <option value="manual">Manual</option>
                  </select>
                </div>
          <!--     <div class="form-group">
                <label for="datetime1">License Expiry Date</label>
                    <input id="datetimepicker" class="form-control" type="text" name="expired_on">
                </div> -->

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info" id="userSave">Save</button>
            <button type="button" class="btn btn-info" id="userContinue"  style="display: none">Contiue</button>
         </div>
            </form>

      </div>
   </div>
</div>
<div class="modal fade" id="manualPaymentForm" tabindex="-1" role="dialog" aria-labelledby="manualPaymentModal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel1">Add Payment</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
           <form method="post" action="{{route('plan.store')}}">
         <div class="modal-body">

              @csrf

              <input type="hidden" name="stripe_plan" value="{{Str::random(7)}}">
              <input type="hidden" name="plan_id" value="{{Str::random(7)}}">
              <input type="hidden" name="product_id" value="virtualProduct_{{Str::random(7)}}">
              <input type="hidden" name="quantity" value="1">
              <input type="hidden" name="name" value="default">
              <input type="hidden" name="user_id">
               <div class="form-group">
                  <label for="plan-name" class="control-label">Links Quantity:</label>
                  <input type="text" class="form-control" id="plan-Quantity" name="quantity" value="100">
               </div>
                <div class="form-group">
                  <label for="plan-name" class="control-label">Files Allowed:</label>
                  <input type="text" class="form-control" id="payment-files-allowed" name="allowed_files"value="10">
               </div>
                <div class="form-group">
                  <label for="plan-name" class="control-label">Storage: (GB)</label>
                  <input type="text" class="form-control" id="plan-storage" name="storage"value="5">
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Cost:</label>
                  <input type="text" class="form-control" id="plan-cost" name="cost"value="100">
               </div>

                <div class="form-group">
                  <label for="plan-name" class="control-label">Currency:</label>
                  <select class="form-group" name="currency">
                    <option value="USD">USD</option>
                    <option value="EUR">Euro</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Duration:</label>
                 <select class="form-group"  name="interval">
                    <option value="month">Monthly</option>
                    <option value="year">Yearly</option>
                  </select>
               </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Save</button>
         </div>
            </form>

      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel1">Add Client</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
            <form method="post" action="{{route('client.store')}}">
         <div class="modal-body">
              @csrf
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Company Name:</label>
                  <input type="text" class="form-control" id="recipient-name5" name="company_name">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Name:</label>
                  <input type="text" class="form-control" id="recipient-name1" name="name">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Email:</label>
                  <input type="email" class="form-control" id="recipient-name2" name="email">
               </div>
               <div class="form-group">
                  <label for="recipient-name" class="control-label">Phone:</label>
                  <input type="text" class="form-control" id="recipient-name3" name="phone">
               </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Save</button>
         </div>
            </form>

      </div>
   </div>
</div>

<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModalLabel1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="planModalLabel1">Add Plan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
           <form method="post" action="{{route('plan.store')}}">
         <div class="modal-body">

              @csrf
              <div class="form-group">
                  <label for="plan-name" class="control-label">Plan Name:</label>
                  <input type="text" class="form-control" id="plan-name1" name="name">
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Links Quantity:</label>
                  <input type="text" class="form-control" id="plan-Quantity" name="quantity" value="100">
               </div>
                <div class="form-group">
                  <label for="plan-name" class="control-label">Files Allowed:</label>
                  <input type="text" class="form-control" id="plan-files-allowed" name="allowed_files" value="10">
               </div>
                <div class="form-group">
                  <label for="plan-name" class="control-label">Storage: (GB)</label>
                  <input type="text" class="form-control" id="plan-storage" name="storage" value="5">
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Plan Cost:</label>
                  <input type="text" class="form-control" id="plan-cost" name="cost" value="100">
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Description:</label>
                  <input type="textarea" class="form-control" id="plan-description" name="description">
               </div>
                <div class="form-group">
                  <label for="plan-name" class="control-label">Currency:</label>
                  <select class="form-group" name="currency">
                    <option value="USD">USD</option>
                    <option value="EUR">Euro</option>
                  </select>
               </div>
               <div class="form-group">
                  <label for="plan-name" class="control-label">Duration:</label>
                 <select class="form-group"  name="interval">
                          <option value="month">Monthly</option>
                    <option value="year">Yearly</option>
                  </select>
               </div>

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Save</button>
         </div>
            </form>

      </div>
   </div>
</div>

<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('js/chat.js')}}"></script>
    <!-- Footable -->
    <script src="{{asset('assets/plugins/footable/js/footable.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/footable-init.js')}}"></script>

    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
   <script src="http://cdn.craig.is/js/rainbow-custom.min.js"></script>


    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
      $(document).ready(function() {
       	$('#datetimepicker').datetimepicker({
            format:'Y-m-d H:i:s'
       });
      });
</script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>

    <script type="text/javascript">
         const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })



      $(function(){
        $(".copyLink").click(function(e){

           e.preventDefault();

          var copyText = $(this).attr('data-text');

          var textarea = document.createElement("textarea");
          textarea.textContent = copyText;
          textarea.style.position = "fixed"; // Prevent scrolling to bottom of page in MS Edge.
          document.body.appendChild(textarea);
          textarea.select();
          document.execCommand("copy");

          document.body.removeChild(textarea);
          $(".myTooltip").css("display","block");
          $(".myTooltip").fadeOut(5000);

          Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Link Copied To Clipboard',
            showConfirmButton: false,
            timer: 1500
          })

        });


      });
      //User Save Ajax Before Manual Payment
      $(function(){
        $('select[name="payment_type"]').change(function(){
           if($(this).val()=="manual")
          {
            $("#userContinue").show()
            $("#userSave").hide()
          }
          else
          {
            $("#userContinue").hide()
            $("#userSave").show()
          }

        })
        $("#userContinue").click(function(){
            url="{{route('user.store')}}";
          saveUser()
        });

        function saveUser()
        {

          url="{{route('user.store')}}";
           $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#userForm").serialize(),

                    success: function(data) {
                       $("#exampleModal").modal('hide')
                       $("input[name='user_id']").val(data)
                       $("#manualPaymentForm").modal()
                    },
                    error: function(xhr, textStatus, error){
                      var str=""
                      $.each(JSON.parse(xhr.responseText).errors,function(k,v){
                              str+="<p style='color:red' >"
                               str+=(v[0]);
                               str+="</p>"
                              })
                      console.log(str)
                        swalWithBootstrapButtons.fire(
                              'Error!!',
                              str,
                              'error'
                          )
                    },
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    }
                });
        }

      })
    </script>

  @stack('js')
</body>


</html>

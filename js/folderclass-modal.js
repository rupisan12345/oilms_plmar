$(document).ready(function() {

   var uploadform = document.getElementById('uploadimageform');
   var uploadpop = document.getElementById('uploadpop');
   var $modal = $('#modal');
   var modal_image = document.getElementById('modal-image');
   var cropper;
   $('#upload_image').change(function(event) {
      var files = event.target.files;
      var done = function(url) {
         modal_image.src = url;
         $modal.modal('show');
      };
      if (files && files.length > 0) {
         reader = new FileReader();
         reader.onload = function(event) {
            done(reader.result);
         };
         reader.readAsDataURL(files[0]);
      }
   });

   $modal.on('shown.bs.modal', function() {
      cropper = new Cropper(modal_image, {
         aspectRatio: 4,
         /* 4 */
         viewMode: 6,
         /* 6 */
         preview: '.preview'
      });
   }).on('hidden.bs.modal', function() {
      cropper.destroy();
      cropper = null;
   });

   $('#crop_and_upload').click(function() {
      canvas = cropper.getCroppedCanvas({
         width: 1150,
         height: 200
      });

      canvas.toBlob(function(blob) {
         url = URL.createObjectURL(blob);
         var reader = new FileReader();
         reader.readAsDataURL(blob);
         reader.onloadend = function() {
            var base64data = reader.result;

            $.ajax({
               url: 'backend/folderclass_back.php',
               method: 'POST',
               data: {
                  modal_image: base64data
               },
               success: function(data) {
                  $modal.modal('hide');
                  uploadpop.style.display = 'none';
                  uploadform.reset();
               }
            });

         };
      });

   });

});
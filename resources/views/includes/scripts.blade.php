 <script src="/assets/static/js/components/dark.js"></script>
 <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

 <script src="/assets/compiled/js/app.js"></script>

 <!-- Need: Apexcharts -->
 <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>
 <script src="/assets/static/js/pages/dashboard.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     document.querySelectorAll('.delete-btn').forEach(button => {
         button.addEventListener('click', function() {
             const id = this.dataset.id;

             Swal.fire({
                 title: 'Hapus User?',
                 text: 'Data user ini akan dihapus permanen!',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#d33',
                 cancelButtonColor: '#6c757d',
                 confirmButtonText: 'Ya, hapus!'
             }).then((result) => {
                 if (result.isConfirmed) {
                     document.getElementById(`delete-form-${id}`).submit();
                 }
             });
         });
     });




     @if (session('success'))
         Toastify({
             text: "{{ session('success') }}",
             duration: 3000,
             close: true,
             gravity: "top", // top or bottom
             position: "right", // left, center or right
             backgroundColor: "#4CAF50",
         }).showToast();
     @endif

     @if (session('error'))
         Toastify({
             text: "{{ session('error') }}",
             duration: 3000,
             close: true,
             gravity: "top",
             position: "right",
             backgroundColor: "#f44336",
         }).showToast();
     @endif

     @if (session('warning'))
         Toastify({
             text: "{{ session('warning') }}",
             duration: 3000,
             close: true,
             gravity: "top",
             position: "right",
             backgroundColor: "#ff9800",
         }).showToast();
     @endif
 </script>

<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!'
  },
  
  mounted() {
   this.getOpeningHours();
  },
  
  methods: {
  getOpeningHours() {
     axios.get('https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJXai2QgYLskcRIAb8-oyS5mU&key=AIzaSyCGe4zzblB8biqGd0qAWW4t7bC2QA9O0Kw&language=de')
          .then(function (response) {
               console.log(response.result);
          })
          .catch(function (error) {
               console.log(error);
          });
     }
}
})

</script>
<!-- end Simple Custom CSS and JS -->

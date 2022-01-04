    </div>
    <footer>
        <p>&copy; Copyright by <a href="https://www.spinxdigital.com" ><b>SPINX Digital</b></a> {{ __(date('Y')) }} <br>
        <a href="mailto:marco.spinx@gmail.com">Marco Wilson</a></p>
    </footer>
    <script type="text/javascript">
      $(".es_search").on("click",function() {
        var $title = $("input[name='es_search']").val();
        console.log($title);
        var url = 'http://127.0.0.1:8000/product-search/'+$title;
        window.location.href = url;
      });
    </script>
</body>
</html>

Demo
<script type="text/javascript" src="/node_modules/@wcjiang/notify/dist/notify.min.js"></script>
<script type="text/javascript">
  var notify = new Notify({
    effect: "flash",
    interval: 500,
  });
  notify.setTitle("New title");
  notify.setFavicon("1");
  notify.setInterval(2000);

  notify.notify();
	notify.notify({
	  title: "New notice",
	  body: "Thunder, it’s raining...",
	  openurl: "https://jaywcjlove.github.io",
	  onclick: function () {
	    console.log("on click");
	  },
	  onshow: function () {
	    console.log("on show");
	  },
	});

</script>
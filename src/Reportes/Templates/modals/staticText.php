
<!-- CSS Extends-->
<?=$this->section('addCss')?>
<textarea class="textArea" id="textArea"></textarea>
<script type="text/javascript">
  
       var elementText = $('#'+ViewProperties.elementSelected);
       var value = elementText.text();
       var textArea = $('#textArea');
       textArea.val(value);

</script>
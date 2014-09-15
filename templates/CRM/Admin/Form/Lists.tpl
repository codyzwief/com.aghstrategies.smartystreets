<div class="form-item">
	 <fieldset><legend>{ts}Export CSV file{/ts}</legend>
      <div class="crm-block crm-form-block crm-smartystreets-form-block">
      	<a href="#" style="margin:0 auto; width:50px" id ="download">Download CSV File!!!!</a>
      	<div id="progress"></div>
      </div>
    </fieldset>
    <fieldset><legend>{ts}Import CSV file{/ts}</legend>
        <div class="crm-block crm-form-block crm-smartystreets-form-block">
            <table class="form-layout-compressed">
                <tr class="crm-smartystreets-form-block">
                    <td class="label">Import Csv File</td>
                    <td>{$form.csv_path.html} {$form.csv_path.label}</td>
                </tr>
            </table>
         <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
    </fieldset>
</div>
{literal}
<script type="text/javascript">
	cj("#download").on("click", function(e){
		e.preventDefault();
		alert("started");
    cj.ajax({
              type: "POST",
              url: "/civicrm/admin/setting/smartystreets_download_csv",
              success: function() {
                 alert("we made it");
               }
        });
	});
	
	cj( document ).ajaxStart(function() {
    alert("loading");
  });
</script>
{/literal}
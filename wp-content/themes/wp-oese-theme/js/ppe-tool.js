jQuery( document ).ready(function($) {
	$(document).on('click', '.wpdt-c .wpDataTablesWrapper table.wpDataTable tr td', function(e){
          e.preventDefault();
          let parent = $(this).parent();
          let target = $('#ppe-details-modal');
          let data = {
               school: parent.find('.column-schoolname').text(),
               state: parent.find('.column-state').text(),
               county: parent.find('.column-countyname').text(),
               city: parent.find('.column-city').text(),
               district: parent.find('.column-district').text(),
               zip: parent.find('.column-zip').text(),
               isdn: parent.find('.column-stateschoolid').text(),
               nces: parent.find('.column-ncesdistrictid').text(),
               statelocalppe: parent.find('.column-formula_1').text(),
               federalppe: parent.find('.column-formula_2').text(),
               totalppe: parent.find('.column-formula_3').text()
          };

     	target.find("#schoolName").text(data.school);
     	target.find("#state").text(data.state);
     	target.find("#county").text(data.county);
     	target.find("#city").text(data.city);
     	target.find("#district").text(data.district);
     	target.find("#zip").text(data.zip);
		target.find("#sidn").text(data.isdn);
		target.find("#ncesno").text(data.nces);
		target.find("#totalslppe").text(data.statelocalppe);
		target.find("#totalfppe").text(data.federalppe);
		target.find("#totalppe").text(data.totalppe);
     	target.modal('show').addClass('show');
     });
});
// Insert data function to accept input value and call corresponding databse file to update enteries within database.
function insert_data(){
  var text = jQuery('#title').val().trim();
  //displays error if entered value is empty
  if(text == ''){
    jQuery('#error').html('Please enter data to be submitted.');
  }
  //Ajax for inserting enteries
  else{
    jQuery.ajax({
      url :'../../Database/insert.php',
      method: 'post',
      data: 'text='+text,
      //Function to add new row to display.
      success: function(result){
        const newRow = `
          <tr id="row${result}">
            <td>
              <input type="checkbox" onchange="toggle_box(${result})">
              <span class="data">${text}</span>
            </td>
            <td><a href="javascript:void(0)" onclick="delete_data(${result})">Delete</a></td>
            <td><a href="javascript:void(0)" onclick="edit_data(${result})">Edit</a></td>
          </tr>`;     
        jQuery('#row-data').prepend(newRow);
        jQuery('#title').val('');
        jQuery('#error').html('');
      },
      error: function() {
        jQuery('#error').html('Error inserting data.');
      }
    })
  }
}
//Delete data function accepts id and hides corresponding row from display.
function delete_data(id){
  jQuery.ajax({
    url :'../../Database/delete.php',
    method: 'post',
    data: 'id='+id,
    success: function(result){
      jQuery('#row'+id).hide();
    }
  })
}
// Edit data function accepts id edits the title of corresponding entry.
function edit_data(id){
  const currentText = jQuery(`#row${id} .data`).text();
  const newText = prompt('Edit task:', currentText);
  if(newText && newText.trim() !== ''){
    jQuery.ajax({
      url: '../../Database/edit.php',
      method: 'post',
      data: { id: id, text: newText },
      success: function(){
        jQuery(`#row${id} .data`).text(newText);
      }
    });
  }
}
//Toggle function to add and remove done class for the corresponding row and based on the class of the row adds it to the begining or end of the list.
function toggle_box(id){
  jQuery.ajax({
    url: '../../Database/toggle_status.php',
    method: 'post',
    data: 'id='+id,
    success: function(status){
      const row = jQuery('#row' + id);
      row.toggleClass('done');
      //Check if the row contains done class and accordingly add it to begining or end of list.
      if(row.hasClass('done')){
        jQuery('#row-data').append(row);
      } else {
        jQuery('#row-data').prepend(row);
      }
    }
  });
}

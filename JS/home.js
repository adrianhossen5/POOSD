function formatDatetime(timestamp) {
  const date = new Date(timestamp);
  const options = {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  };
  const formattedDate = date.toLocaleString(undefined, options);
  const formattedWithoutSeconds = formattedDate.replace(/:\d{2}$/, '');
  return formattedWithoutSeconds;
}

$(() => {
  // Sets the table with the given contacts
  function setTable(contacts) {
    const table = $('#contacts').empty();

    Array.from(contacts).forEach((contact) => {
      const formattedTimeCreated = formatDatetime(contact.time_created);
      table.append(`
    		<tr>
          <td>${formattedTimeCreated}</td>
				  <td>${contact.first_name}</td>
				  <td>${contact.last_name}</td>
				  <td>${contact.phone_number}</td>
				  <td>${contact.email}</td>
				  <td><button class="edit-delete-button" onclick="editContact('${contact.first_name}', '${contact.last_name}', '${contact.phone_number}', '${contact.email}', '${contact.id}')">Edit</button></td>
    			<td><button class="edit-delete-button" onclick="deleteContact('${contact.id}')">Delete</button></td>
    			</tr>
			`);
    });

    table.append(`
		<thead style="width:100%">
            <tr>
              <th>Date Created</th>
              <th>First Name</th>
              <th>Last Name</th>
			        <th>Phone Number</th>
              <th>Email</th>
              <th>Edit</th>
			  <th>Delete</th>
            </tr>
          </thead>`);
  }

  $.ajax({
    url: '/API/getAllContacts.php',
    method: 'POST',
    success: (response) => {
      if (response.success) {
        setTable(response.contacts);
      }
    },
    error: () => {
      alert('Failed to load contacts.');
    },
  });
});

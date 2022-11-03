window.onload = () => {

    const buttonsDelete = document.getElementsByName("delete");

    if (buttonsDelete.length > 0) {
        for (var d = 0; d < buttonsDelete.length; d++) {
            console.log(buttonsDelete[d]);
            buttonsDelete[d].onclick = function (event) {
                alert('xxx');
                let id = $(this).data('id');
                // $.ajax({
                //     url: "showText/" + event.target.value,
                //     method: 'DELETE',
                //     dataType: 'html',
                //     data: {
                //         id: id
                //     },
                //     success: function(data){
                //         window.location.replace("/showText?success=сообщение удалено из БД");
                //     }
                // });
            };
        }
    }
    var buttons = document.getElementsByName("delete");
    if (buttons.length > 0) {
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = deleteUser(buttons[i]);
        }
    }

    var buttons = document.getElementsByName("edit");
    if (buttons.length > 0) {
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = editUser(buttons[i]);
        }
    }
};

function deleteUser(val) {
    return function(){alert("пользователь с ID= " + val.value + " удален");};
}

function editUser(val) {
    return function(){alert("пользователь с ID= " + val.value + " отредактирован");};
}
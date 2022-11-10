window.onload = () => {


    var buttonsDelete = document.getElementsByName("delete");

    if (buttonsDelete.length > 0) {
        for (var i = 0; i < buttonsDelete.length; i++) {
            buttonsDelete[i].onclick = deleteUser(buttonsDelete[i]);
        }
    }

    var buttonsEdit = document.getElementsByName("edit");

    if (buttonsEdit.length > 0) {
        for (var i = 0; i < buttonsEdit.length; i++) {
            buttonsEdit[i].onclick = editUser(buttonsEdit[i]);
        }
    }

    var buttonsPersonalAreaUser = document.getElementsByName("PersonalAreaUser");

    if (buttonsPersonalAreaUser.length > 0) {
        for (var i = 0; i < buttonsPersonalAreaUser.length; i++) {
            buttonsPersonalAreaUser[i].onclick = personalAreaUser(buttonsPersonalAreaUser[i]);
        }
    }
};

function deleteUser(val) {
    return function(){
        alert("пользователь с ID= " + val.value + " удален");
    let id = val.value;
    $.ajax({
        url: "user/" + val.value,
        method: 'DELETE',
        dataType: 'html',
        data: {
            id: id
        },
        success: function(data){
            window.location.replace("/user?success=пользователь удалено из БД");
        }
    });
    };
}

function editUser(val) {
    return function(){alert("пользователь с ID= " + val.value + " отредактирован");};
}

function personalAreaUser(val) {
    return function(){
        window.location.href = '/user/' +val.value;
    };
}
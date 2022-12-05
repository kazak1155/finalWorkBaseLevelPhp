// window.onload = () => {
//
//
//     var buttonsDelete = document.getElementsByName("delete");
//
//     if (buttonsDelete.length > 0) {
//         for (var i = 0; i < buttonsDelete.length; i++) {
//             buttonsDelete[i].onclick = deleteUser(buttonsDelete[i]);
//         }
//     }
//
//     var buttonsEditForm = document.getElementsByName("editForm");
//
//     if (buttonsEditForm.length > 0) {
//         for (var i = 0; i < buttonsEditForm.length; i++) {
//             buttonsEditForm[i].onclick = editUserForm(buttonsEditForm[i]);
//         }
//     }
//
//     var buttonsEdit = document.getElementsByName("edit");
//
//     if (buttonsEdit.length > 0) {
//         for (var i = 0; i < buttonsEdit.length; i++) {
//             buttonsEdit[i].onclick = editUser(buttonsEdit[i]);
//         }
//     }
//
//     var buttonsPersonalAreaUser = document.getElementsByName("PersonalAreaUser");
//
//     if (buttonsPersonalAreaUser.length > 0) {
//         for (var i = 0; i < buttonsPersonalAreaUser.length; i++) {
//             buttonsPersonalAreaUser[i].onclick = personalAreaUser(buttonsPersonalAreaUser[i]);
//         }
//     }
// };
//
// function deleteUser(val) {
//     return function(){
//     let id = val.value;
//     $.ajax({
//         url: "user/" + val.value,
//         method: 'DELETE',
//         dataType: 'html',
//         data: {
//             id: id
//         },
//         success: function(data){
//             window.location.reload();
//         }
//     });
//     };
// }
//
// function editUserForm(val) {
//     return function(){window.location.replace("/editUser/" + val.value);};
// }
//
// function editUser(val) {
//     return function(){
//         alert("пользователь с ID= " + val.value + " отредактирован");
//         let id = val.value;
//         $.ajax({
//             url: "user/" + val.value,
//             method: 'PUT',
//             dataType: 'html',
//             data: {
//                 id: id
//             },
//             success: function(data){}
//         });
//     };
// }
//
// function personalAreaUser(val) {
//     return function(){
//         window.location.href = '/user/' +val.value;
//     };
// }
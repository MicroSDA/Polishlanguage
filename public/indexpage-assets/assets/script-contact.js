$(function(){
 $('#register-new-user-form').validate({
   rules: {
     name: {
       required: true,
       minlength: 2
     }
   },
   messages: {
     name: {
       required: "Заполните Имя",
       minlength: "Введите не менее 2-х символов в поле 'Имя'"
     },
     email: {
       required: "Заполните email адрес",
       email: "Неверный формат адреса email"
     },
     phone: "Заполните номер телефона"
   }
 });
});

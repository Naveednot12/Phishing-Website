document.addEventListener('DOMContentLoaded', function(){
    
    var pass = document.getElementById('password');
    var showpass = document.getElementById('showpassword');

    showpass.addEventListener('change', function(){
        if(showpass.checked){
            pass.type="text";
        }
        else{
            pass.type="password";
        }
    });
});

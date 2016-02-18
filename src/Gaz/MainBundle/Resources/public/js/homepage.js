/**
 * Created by tigran on 12/11/15.
 */

$(document).ready(function(){
    select();
});
function select()
{
    $( "#cart_login_cart").select();
    $('*').click(function(){
        $( "#cart_login_cart").select();
    });
}
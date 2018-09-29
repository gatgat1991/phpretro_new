<?php

function loadInfos() {
    var url = window.location.href;
    var parameter = url.split("/");
    var sendparamenter = false;
    if (parameter[1] == "me") {
        var current_price = $(".rareauctionprice").html();
        if (current_price) {
            sendparamenter = current_price;
        } else {
            sendparamenter = 0;
        }
    }

function loadInfos() {
    var url = window.location.href;
    var parameter = url.split("/");
    var sendparamenter = false;
    if (parameter[1] == "me") {
        var current_price = $(".rareauctionprice").html();
        if (current_price) {
            sendparamenter = current_price;
        } else {
            sendparamenter = 0;
        }
    }
    $.post("/Infos.php", {
        rareauction: sendparamenter
    }).done(function(data) {
        var json = jQuery.parseJSON(data);
        $("user").html(json.users);
        if (json.users < 2) {
            $("desc").html('Üye çevrimiçi');
        } else {
            $("desc").html('Üye çevrimiçi');
        }
        if (json.rareauction) {
            if (json.rareauction.username) {

            $(".rareauctionusername").html(json.rareauction.username).stop(true, true).fadeOut(1300).stop(true, true).fadeIn(1300);
            $(".rareauctionprice").html("<b style="font-weight: 100;">En Yüksek Teklif:</b> " + json.rareauction.count_format).stop(true, true).fadeOut(1300).stop(true, true).fadeIn(1300);
            $("#reinput").val(json.rareauction.count+1).stop(true, true).fadeOut(1300).stop(true, true).fadeIn(1300);
            $(".rareauctionwindow").css('background', 'url(' + json.rareauction.look + ')  10px 0% no-repeat').stop(true, true).fadeOut(1300).stop(true, true).fadeIn(1300);

                $.get( "/habblet/onlineanzeige.php", function( data ) {
                        var data = data;
                        $("#onlineanzeige").css('height', 'auto').html(data).stop(true, true).fadeOut(1300).stop(true, true).fadeIn(1300);
                });



            }
        }
        if (json.alert) {
            NotifyUser(json.alert.icon, json.alert.title, json.alert.body, json.alert.url);
        }
    });
}
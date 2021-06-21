(function ($, webid, window, document) {
    webid.init = webid.init || function () {
        $(document).ready(function() {
            $('a.new-window').click(function(){
                var posY = ($(window).height()-550)/2;
                var posX = ($(window).width())/2;
                window.open(this.href, this.alt, "toolbar=0,location=0,directories=0,scrollbars=1,screenX="+posX+",screenY="+posY+",status=0,menubar=0,width=550,height=550");
                return false;
            });
            var serverdate = new Date();
            function padlength(what){
                return (what.toString().length==1)? "0"+what : what;
            }
            function displaytime(){
                serverdate.setSeconds(serverdate.getSeconds()+1);
                var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds());
                $("#servertime").html(timestring);
            }
            setInterval(displaytime, 1000);
        });

        $(document).ready(function () {
            webid.auctionTimers.init();
        });
    };

    var auctionTimers = webid.auctionTimers = webid.auctionTimers || (function () {
        var initialize = function () {
            $(document).ready(function() {
                if ($('#ending_counter').length) {
                    updateTimer();
                }
            });
        };

        var padlength = function (what) {
            return (what.toString().length == 1)? '0' + what : what;
        }

        var updateTimer = function () {
            var $element = $('#ending_counter');
            var currenttime = $element.data('wb-ends-in');

            if (currenttime > 0) {
                var hours = Math.floor(currenttime / 3600);
                var mins = Math.floor((currenttime - (hours * 3600)) / 60);
                var secs = Math.floor(currenttime - (hours * 3600) - (mins * 60));
                var timestring = padlength(hours) + ':' + padlength(mins) + ':' + padlength(secs);

                $element.html(timestring);

                $element.data('wb-ends-in', currenttime -= 1);

                setTimeout(updateTimer, 1000);
            }
        }

        return {
            init: initialize,
        }
    }());

}(jQuery, window.webid = window.webid || {}, window, document));

webid.init();

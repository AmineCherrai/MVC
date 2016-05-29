var menuToggleSpd = "slow";

var toggleChevron = function(elem)
{
    if ($(elem).hasClass("shown"))
    {
        $(elem).removeClass("shown").addClass("hidden");
        $("img", elem).attr("src",capanelURL+"images/chevron.png");
    }
    else
    {
        $(elem).removeClass("hidden").addClass("shown");
        $("img", elem).attr("src",capanelURL+"images/chevron-expand.png");
    }
};

$(document).ready(function (){

    $(".goto-title").click(function (){

        $(this).next("div.goto-list").slideToggle(menuToggleSpd);

        var chevron = $(".goto-chevron a",this);

        toggleChevron(chevron);

        return false;
    });

    $(".expand-all").click(function (){

        $(".goto-list").slideDown(menuToggleSpd);

        $(".goto-chevron a").removeClass("shown").addClass("hidden");

        $("img",".goto-chevron a").attr("src",capanelURL+"images/chevron.png");

        return false;
    });

    $(".close-all").click(function (){

        $(".goto-list").slideUp(menuToggleSpd);

        $(".goto-chevron a").removeClass("hidden").addClass("shown");

        $("img",".menu-chevron a").attr("src",capanelURL+"images/chevron-expand.png");

        return false;
    });

    $('a.show_tipsy').tipsy({gravity: 's'});

});
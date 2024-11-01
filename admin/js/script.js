jQuery(document).ready(function($){
    var option = $("#customizeSettingB").val();
    changeCustomizeStatus(option);
    $('#customizeSettingB').on('change',function(){
        var option = $(this).val();
        changeCustomizeStatus(option);
    });

    function changeCustomizeStatus(option){
        var rac = $('#rowAlternateColor');
        var cac = $('#columnAlternateColor');
        var frfc = $('#fcfr');
        switch(option) {
        case '1':
            rac.show();
            cac.hide();
            frfc.hide();
            break;
        case '2':
            rac.hide();
            cac.show();
            frfc.hide();
            break;
        case '3':
            rac.hide();
            cac.hide();
            frfc.show();
            break;
        default:
            rac.show();
            cac.hide();
            frfc.hide();
            break;
        }
    }



    $('#bswidgetdatatype').on('change',function(){
        var data_type = $(this).val();
        if(data_type){
            $.ajax({
                type:'POST',
                url:ajaxurl,
                data:{action : "ce_bsw_fetchTeams" , data_type:data_type},
                success:function(html){
                    $('#bswidgettournament').html('<option value="">Select</option>');
                    $('#bswidgettournament').append(html);
                    if(data_type == '3'){
                        $('#bswidgetgroup').hide();
                        $('#bswidgetgroup').val('');
                    }
                    processChange();
                    $("#bswidgettournament").val($("#bswidgettournament option:first").val());
                },

            }); 
        }else{
            $('#bswidgettournament').html('<option value="">Select</option>');
        }
    });

    $('#bswidgettournament').on('change',function(){

        var leagueID = $(this).val();
        if(leagueID){
            $.ajax({
                type:'POST',
                url:ajaxurl,
                data:{action : "ce_bsw_fetchGroup" , leagueID:leagueID},
                success:function(html){
                    $('#bswidgetgroup').html(html);
                    processChange();
                    $("#bswidgetgroup").val($("#bswidgetgroup option:first").val());
                },

            }); 
        }
    });

    $('#bswidget-generator select').on('change',function(){
        processChange();
    });

    function processChange(){
        var language = $('#bswidgetlanguage').val();
        var dataType = $('#bswidgetdatatype').val();
        var tournament = $('#bswidgettournament').val();
        var group = $('#bswidgetgroup').val();

        if((dataType ==1) || (dataType ==2) || (dataType ==3)){
            $(".isLeagueN").hide();
        }else{
            $(".isLeagueN").show();
        }

        if((dataType == 0) || (language  == 0) || (tournament == 0)){
            $('#ShortcodePrev').html('Please Select The Required Fields');
            return;
        }else{
            if((group == '') || (group == null) || (group == 0)){
                grp ='';
            }else{
                var grp = ' group='+group;
            }

            if ($('#bswidgetgroup option').length == 0) {
                $('#bswidgetgroup').hide();
                $('#bswidgetgroup').val('');
            }else{
                $('#bswidgetgroup').show();
            }

            $('#ShortcodePrev').html('[basketstats lang='+language+' type='+dataType+' ranking='+tournament+''+grp+']');
            processPreview(language,dataType,tournament,group);
        }
    }
    function processPreview(language,dataType,tournament,group){
        $.ajax({
            type:'POST',
            url:ajaxurl,
            data:{action : "ce_bsw_processPreview", Language:language, DataType:dataType,tournament:tournament,Group:group},
            success:function(html){
                html = html.replace(new RegExp('/"/', 'g'), '"');
                $('#bswidgetPreviewDemo').html(html);
            },

        });
    }
});



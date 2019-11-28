function url() {
    return window.location.origin + '/eform/';
}
$(document).ready(function() {
    /* select2 */
    $(".s2").select2();
    /* add mm font on select2 */
    $(".s2").on("select2:open", function(e) {
        if ($(this).hasClass("mm")) {
            $(".select2-dropdown--below").addClass("mm");
        }
    });

    $(".textarea_editor").wysihtml5();
    $(".textarea_editor1").wysihtml5();
    $(".textarea_editor2").wysihtml5();
    $(".textarea_editor3").wysihtml5();
    $(".textarea_editor5").wysihtml5();
    $(".textarea_editor6").wysihtml5();

    $(".mydatepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "dd-mm-yyyy"
    });
});
$(document).ready(function() {
    $("#room").on("change", function() {
        var meter = Number($(this).val());
        $("#residentialMeter").val(meter);
    });

    $("#pMeter10").on("blur", function() {
        var meter10k = Number($("#pMeter10").val());
        var meter20k = Number($("#pMeter20").val());
        var meter30k = Number($("#pMeter30").val());
        var total = meter10k + meter20k + meter30k;
        var resMeter = Number($("#room").val());
        if (resMeter >= total) {
            var meterDiff = resMeter - total;
            $("#residentialMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });

    $("#pMeter20").on("blur", function() {
        var meter10k = Number($("#pMeter10").val());
        var meter20k = Number($("#pMeter20").val());
        var meter30k = Number($("#pMeter30").val());
        var total = meter10k + meter20k + meter30k;
        var resMeter = Number($("#room").val());
        if (resMeter >= total) {
            var meterDiff = resMeter - total;
            $("#residentialMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });

    $("#pMeter30").on("blur", function() {
        var meter10k = Number($("#pMeter10").val());
        var meter20k = Number($("#pMeter20").val());
        var meter30k = Number($("#pMeter30").val());
        var total = meter10k + meter20k + meter30k;
        var resMeter = Number($("#room").val());
        if (resMeter >= total) {
            var meterDiff = resMeter - total;
            $("#residentialMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });

    // Survey Meter Auto diff
    $("#surveyPmeter10").on("blur", function() {
        var meter10k = Number($("#surveyPmeter10").val());
        var meter20k = Number($("#surveyPmeter20").val());
        var meter30k = Number($("#surveyPmeter30").val());
        var total = meter10k + meter20k + meter30k;
        var totalRoom = Number($("#roomCount").val());
        if (totalRoom >= total) {
            var meterDiff = totalRoom - total;
            $("#surveyMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });

    $("#surveyPmeter20").on("blur", function() {
        var meter10k = Number($("#surveyPmeter10").val());
        var meter20k = Number($("#surveyPmeter20").val());
        var meter30k = Number($("#surveyPmeter30").val());
        var total = meter10k + meter20k + meter30k;
        var totalRoom = Number($("#roomCount").val());
        if (totalRoom >= total) {
            var meterDiff = totalRoom - total;
            $("#surveyMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });

    $("#surveyPmeter30").on("blur", function() {
        var meter10k = Number($("#surveyPmeter10").val());
        var meter20k = Number($("#surveyPmeter20").val());
        var meter30k = Number($("#surveyPmeter30").val());
        var total = meter10k + meter20k + meter30k;
        var totalRoom = Number($("#roomCount").val());
        if (totalRoom >= total) {
            var meterDiff = totalRoom - total;
            $("#surveyMeter").val(meterDiff);
        } else {
            $(this).focus();
        }
    });
    // End of Survey Meter auto diff

    // JobType Select Function
    $("#jobType").on("change", function() {
        var type = $(this).val();
        if (type == "gstaff" || type == "staff") {
            $("#gStaff-wrap").removeClass("d-none");
        } else {
            $("#gStaff-wrap").addClass("d-none");
        }

        if (type == 'other') {
            $("#otherWrap").removeClass('d-none');
        }
        else {
            $('#otherWrap').addClass('d-none');
        }
    });

    $(".refresh_captcha").on("click", function() {
        $.ajax({
            type: "GET",
            url: url() + "/refresh_captcha",
            success: function(data) {
                $(".captcha_src").attr("src", data.captcha);
            }
        });
    });

    /* for fill 09: */
    $('#phone').on('focus', function() {
        var ph_no = $(this).val();
            if (ph_no === '') {
            $(this).val('09');
        }
    });
    $("#phone").on("blur", function() {
        // var ph_no = /^\d+$/.test($(this).val());
        var ph_no = $(this).val();
        if ($(this).val().length < 9 || $(this).val().length > 11) {
            $(".ph-chk-reg").show();
            $("#phone").addClass('is-invalid');
        } else {
            $(".ph-chk-reg").hide();
            $("#phone").removeClass('is-invalid');
        }
    });

    $(".rr-ok").on("click", function() {
        $(".rr-accept").waitMe({
            effect: "bounce",
            waitTime: 2000,
            onClose: function() {
                $(".rr-accept").toggleClass("disabled");
            }
        });
    });

    /* region js */
    $("#region").on("change", function() {
        var region_id = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            type: "POST",
            url: url() + "/choose_region",
            data: { id: region_id },
            success: function(e) {
                $("#district").html(e.district);
                $("#township").html(e.township);
            }
        });
    });

    $("#district").on("change", function() {
        var district_id = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            type: "POST",
            url: url() + "/choose_district",
            data: { id: district_id },
            success: function(e) {
                $("#township").html(e);
            }
        });
    });

    $("#township").on("change", function() {
        var township = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            type: "POST",
            url: url() + "/choose_township",
            data: { id: township },
            dataType: "JSON",
            success: function(e) {
                $("#region").val(e["r_name"]);
                $("#region_id").val(e["r_id"]);
                $("#district").val(e["d_name"]);
                $("#district_id").val(e["d_id"]);
            }
        });
    });

    $(".delete_front").on("click", function(e) {
        e.preventDefault();
        $("#front_preview").attr("src", "");
        $("#front_preview").removeAttr("width");
        $("#front_preview").removeAttr("height");
        $(".front_preview").addClass("d-none");
        $(".front").val("");
    });

    /* NRC delete */
    $(".delete_back").on("click", function(e) {
        e.preventDefault();
        $("#back_preview").attr("src", "");
        $("#back_preview").removeAttr("width");
        $("#back_preview").removeAttr("height");
        $(".back_preview").addClass("d-none");
        $(".back").val("");
    });

    /* Form10 back delete */
    $(".delete_old_back").on("click", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var data = $("#old_back").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.ajax({
            type: "POST",
            url: url() + "/delete_old_back",
            data: { id: id, data: data },
            complete: function() {
                $(".preview_old_back").addClass("d-none");
                $("#old_back").val("");
            }
        });
    });

    /* Multiple Image Preview */
    if (window.File && window.FileList && window.FileReader) {
        $("#uploadFile").on("change", function(e) {
            $(".pre-img").remove();
            var files = e.target.files,
                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
                    var file = e.target;
                    $("#image_preview").append(
                        '<div class="col-2 text-center pre-img">' +
                            '<img class="img-thumbnail custom-img-thumbnail" src="' +
                            e.target.result +
                            '" title="' +
                            name +
                            '" />' +
                            // "<br/><span class=\"cursor-p remove\">Remove</span>" +
                            "</div>"
                    );
                    $(".btn-remove").removeClass("d-none");

                    // remove
                    $(".btn-remove").click(function() {
                        $(".pre-img").remove();
                        $("#uploadFile").val("");
                        $(this).addClass("d-none");
                    });
                };
                fileReader.readAsDataURL(f);
            }
        });
    }

    /* Delete for Multiple Image Preview */
    $(".del_multi_img").on("click", function() {
        $(this)
            .parent(".img")
            .remove();
    });

    $("#type").on("change", function() {
        var val = $(this).val();
        if (val == 6) {
            $(".date_type").removeClass("d-none");
        } else {
            $(".date_type").addClass("d-none");
        }
    });
});

/* NRC image preview */
function readURL(input, place) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            if (place === "front") {
                $(".front_preview").removeClass("d-none");
                $("#front_preview")
                    .attr("src", e.target.result)
                    .width(175)
                    .height(130);
            } else {
                $(".back_preview").removeClass("d-none");
                $("#back_preview")
                    .attr("src", e.target.result)
                    .width(175)
                    .height(130);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* Admin Panel */
$(document).ready(function() {
    $('.dataReset').on('click', function(e){
        e.preventDefault();
            $.ajax({
                type:'POST',
                url:url()+ '/resetDivisionState',
                success:function(data){
                    console.log(data);
                    $("#filter_div_state").html(data.output);
                    document.forms["myForm"].reset();
                }
            });
    });
   

    // nav dropdown
    $(".scroll-sidebar li .cursor-p").click(function(e) {
        var toggle = $(this).data("toggle");
        $(toggle).slideToggle();
        if (toggle !== ".custom_dropdown1") {
            $(".custom_dropdown1").hide();
        }
        if (toggle !== ".custom_dropdown2") {
            $(".custom_dropdown2").hide();
        }
        if (toggle !== ".custom_dropdown3") {
            $(".custom_dropdown3").hide();
        }
        if (toggle !== ".custom_dropdown4") {
            $(".custom_dropdown4").hide();
        }
        if (toggle !== ".custom_dropdown5") {
            $(".custom_dropdown5").hide();
        }
        if (toggle !== ".custom_dropdown6") {
            $(".custom_dropdown6").hide();
        }
    });

    /* Role edit */
    $(".btnRoleEdit").on("click", function() {
        var role_name = $(this).data("rolename");
        var role_id = $(this).data("roleid");
        $("#role_id").val(role_id);
        $("#role_name").val(role_name);
        $(".btnRoleCancel").removeClass("d-none");
        $(".btnCreateDel").removeClass("btn-outline-info");
        $(".btnCreateDel").addClass("btn-outline-warning");
    });

    /* Role edit cancel */
    $(".btnRoleCancel").on("click", function() {
        $("#role_name").val("");
        $("#role_id").val("");
        $(".btnCreateDel").removeClass("btn-outline-warning");
        $(".btnCreateDel").addClass("btn-outline-info");
        $(this).addClass("d-none");
    });

    // edit btn spin
    $(".btn-edit i").on("mouseenter mouseleave", function() {
        $(this).toggleClass("fa-spin");
    });

    // User Stages shown
    $("#step1").show();
    $("#step2").hide();
    $("#step3").hide();
    $("#step4").hide();
    $("#step5").hide();
    $("#step6").hide();
    $('[href="#step"]').on("click", function() {
        event.preventDefault();
        var sele = $(this).data("toggle");
        $(".toggle-panel")
            .children()
            .hide();
        $(sele).show();
        // console.log();
        // $(sele).closest('div').hide();
    });
});

// ======================================== update Permission in Role->show ============================================= //
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // ==================== READ ========================== //
    // ==================================================== //
    $("input:checkbox[name='read']").on("click", function() {
        var role = $(this).data("role");
        read_perm = $(this).data("per");
        write_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='write']")
            .data("per");
        edit_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='edit']")
            .data("per");
        delete_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='delete']")
            .data("per");
        detailRead_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='detailRead']")
            .data("per");
        confirm_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='confirm']")
            .data("per");

        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "read",
                role: role,
                read_perm: read_perm,
                write_perm: write_perm,
                edit_perm: edit_perm,
                delete_perm: delete_perm,
                detailRead_perm: detailRead_perm,
                confirm_perm: confirm_perm
            },
            success: function(e) {
                $(".write" + role + write_perm).prop("checked", e.write);
                $(".edit" + role + edit_perm).prop("checked", e.edit);
                $(".delete" + role + delete_perm).prop("checked", e.delete);
                $(".detailRead" + role + detailRead_perm).prop(
                    "checked",
                    e.detail
                );
                if (confirm_perm !== null) {
                    $(".confirm" + role + confirm_perm).prop(
                        "checked",
                        e.confirm
                    );
                }
            }
        });
    });
    // ==================== WRITE ========================== //
    // ===================================================== //
    $("input:checkbox[name='write']").on("click", function() {
        var role = $(this).data("role");
        write_perm = $(this).data("per");
        read_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='read']")
            .data("per");
        edit_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='edit']")
            .data("per");
        delete_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='delete']")
            .data("per");
        detailRead_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='detailRead']")
            .data("per");
        confirm_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='confirm']")
            .data("per");
        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "write",
                role: role,
                write_perm: write_perm,
                read_perm: read_perm,
                edit_perm: edit_perm,
                delete_perm: delete_perm,
                detailRead_perm: detailRead_perm,
                confirm_perm: confirm_perm
            },
            success: function(e) {
                $(".read" + role + read_perm).prop("checked", e.read);
                $(".edit" + role + edit_perm).prop("checked", e.edit);
                $(".delete" + role + delete_perm).prop("checked", e.delete);
                $(".detailRead" + role + detailRead_perm).prop(
                    "checked",
                    e.detail
                );
                if (confirm_perm !== null) {
                    $(".confirm" + role + confirm_perm).prop(
                        "checked",
                        e.confirm
                    );
                }
            }
        });
    });
    // ==================== EDIT ========================== //
    // ==================================================== //
    $("input:checkbox[name='edit']").on("click", function() {
        var role = $(this).data("role");
        edit_perm = $(this).data("per");

        read_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='read']")
            .data("per");
        write_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='write']")
            .data("per");
        delete_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='delete']")
            .data("per");
        detailRead_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='detailRead']")
            .data("per");
        confirm_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='confirm']")
            .data("per");

        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "edit",
                role: role,
                edit_perm: edit_perm,
                read_perm: read_perm,
                write_perm: write_perm,
                delete_perm: delete_perm,
                detailRead_perm: detailRead_perm,
                confirm_perm: confirm_perm
            },
            success: function(e) {
                $(".read" + role + read_perm).prop("checked", e.read);
                $(".write" + role + write_perm).prop("checked", e.write);
                $(".delete" + role + delete_perm).prop("checked", e.delete);
                $(".detailRead" + role + detailRead_perm).prop(
                    "checked",
                    e.detail
                );
                if (confirm_perm !== null) {
                    $(".confirm" + role + confirm_perm).prop(
                        "checked",
                        e.confirm
                    );
                }
            }
        });
    });
    // ==================== DELETE ========================== //
    // ====================================================== //
    $("input:checkbox[name='delete']").on("click", function() {
        var role = $(this).data("role");
        delete_perm = $(this).data("per");

        read_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='read']")
            .data("per");
        write_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='write']")
            .data("per");
        edit_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='edit']")
            .data("per");
        detailRead_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='detailRead']")
            .data("per");
        confirm_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='confirm']")
            .data("per");

        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "delete",
                role: role,
                delete_perm: delete_perm,
                read_perm: read_perm,
                write_perm: write_perm,
                edit_perm: edit_perm,
                detailRead_perm: detailRead_perm,
                confirm_perm: confirm_perm
            },
            success: function(e) {
                $(".read" + role + read_perm).prop("checked", e.read);
                $(".write" + role + write_perm).prop("checked", e.write);
                $(".edit" + role + edit_perm).prop("checked", e.edit);
                $(".detailRead" + role + detailRead_perm).prop(
                    "checked",
                    e.detail
                );
                if (confirm_perm !== null) {
                    $(".confirm" + role + confirm_perm).prop(
                        "checked",
                        e.confirm
                    );
                }
            }
        });
    });
    // ==================== DETAILREAD ====================== //
    // ====================================================== //
    $("input:checkbox[name='detailRead']").on("click", function() {
        var role = $(this).data("role");
        detailRead_perm = $(this).data("per");

        read_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='read']")
            .data("per");
        write_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='write']")
            .data("per");
        edit_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='edit']")
            .data("per");
        delete_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='delete']")
            .data("per");
        confirm_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='confirm']")
            .data("per");

        console.log(
            read_perm +
                "/" +
                write_perm +
                "/" +
                edit_perm +
                "/" +
                delete_perm +
                "/" +
                detailRead_perm +
                "/" +
                confirm_perm
        );
        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "detailRead",
                role: role,
                detailRead_perm: detailRead_perm,
                read_perm: read_perm,
                write_perm: write_perm,
                edit_perm: edit_perm,
                delete_perm: delete_perm,
                confirm_perm: confirm_perm
            },
            success: function(e) {
                $(".read" + role + read_perm).prop("checked", e.read);
                $(".write" + role + write_perm).prop("checked", e.write);
                $(".edit" + role + edit_perm).prop("checked", e.edit);
                $(".delete" + role + delete_perm).prop("checked", e.delete);
                if (confirm_perm !== null) {
                    $(".confirm" + role + confirm_perm).prop(
                        "checked",
                        e.confirm
                    );
                }
                console.log(e);
            }
        });
    });
    // ==================== CONFIRM ====================== //
    // ====================================================== //
    $("input:checkbox[name='confirm']").on("click", function() {
        var role = $(this).data("role");
        confirm_perm = $(this).data("per");

        read_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='read']")
            .data("per");
        write_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='write']")
            .data("per");
        edit_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='edit']")
            .data("per");
        delete_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='delete']")
            .data("per");
        detialRead_perm = $(this)
            .closest("tr")
            .find("input:checkbox[name='detialRead']")
            .data("per");

        $.ajax({
            type: "POST",
            url: url() + "/role_action",
            data: {
                name: "confirm",
                role: role,
                confirm_perm: confirm_perm,
                read_perm: read_perm,
                write_perm: write_perm,
                edit_perm: edit_perm,
                delete_perm: delete_perm,
                detialRead_perm: detialRead_perm
            },
            success: function(e) {
                $(".read" + role + read_perm).prop("checked", e.read);
                $(".write" + role + write_perm).prop("checked", e.write);
                $(".edit" + role + edit_perm).prop("checked", e.edit);
                $(".delete" + role + delete_perm).prop("checked", e.delete);
                $(".detailRead" + role + detailRead_perm).prop(
                    "checked",
                    e.detail
                );
            }
        });
    });

    /* Form Error Resend Modal */
    $("#myResendModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        $(this)
            .find(".modal-body #form_id")
            .val(id);
    });

    $("#mySurveyResendModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        // alert(id);
        var type = button.data("type");
        
        if (type == 2) {
            $(this)
                .find("#re_form_id_dist")
                .val(id);
            $(".dist_form").removeClass("d-none");
        }
        if (type == 3) {
            $(this)
                .find("#re_form_id_divstate")
                .val(id);
            $(".div_state_form").removeClass("d-none");
        }
    });


    $("#myRejectModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var type = button.data("type");
        
        if (type == 2) {
            $(this)
                .find("#r_form_id_dist")
                .val(id);
            $(".dist_form").removeClass("d-none");
        }
        if (type == 3) {
            $(this)
                .find("#r_form_id_divstate")
                .val(id);
            $(".div_state_form").removeClass("d-none");
        }
    });

    $("#myPendingModal").on("show.bs.modal", function(event) {
        var button = $(event.relatedTarget);
        var id = button.data("id");
        var type = button.data("type");
        console.log(id+'//'+type);
        if (type == 2) {
            $(this)
                .find("#p_form_id_dist")
                .val(id);
            $(".dist_form").removeClass("d-none");
        }
        if (type == 3) {
            $(this)
                .find("#p_form_id_divstate")
                .val(id);
            $(".div_state_form").removeClass("d-none");
        }
    });

    $(".print_confirm").on("click", function() {
        var id = $(this).data("id");
        $("#id").val(id);
    });

    /* office payment before contract */
    // $("#office_pay_chkbox").on("click", function() {
    //     if (this.checked) {
    //         $(".custom-office").addClass("text-danger");
    //         $(".chk-office-box").removeClass("d-none");
    //         $("#online_pay_chkbox").attr("disabled", "disabled");
    //     } else {
    //         $(".custom-office").removeClass("text-danger");
    //         $(".chk-office-box").addClass("d-none");
    //         $("#online_pay_chkbox").removeAttr("disabled");
    //         $("#office_pay_text").val("");
    //     }
    // });

    /* online payment before contract */
    // $("#online_pay_chkbox").on("click", function() {
    //     if (this.checked) {
    //         $(".custom-online").addClass("text-danger");
    //         $(".chk-online-box").removeClass("d-none");
    //         $("#office_pay_chkbox").attr("disabled", "disabled");
    //     } else {
    //         $(".custom-online").removeClass("text-danger");
    //         $(".chk-online-box").addClass("d-none");
    //         $("#office_pay_chkbox").removeAttr("disabled");
    //         $("#online_pay_text").val("");
    //     }
    // });

    /* User Mail for hiding mail alert */
    $(".mail-dd").on("click", function() {
        $(".nav-nottify").removeClass("notify");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $.post(url() + "/disabled_mail_alert");
    });

    /* User Mail click single mail */
    $(".clk-mail").on("click", function() {
        var mail_id = $(this).data("id");
        // alert(mail_id);
        // $('.nav-noti').removeClass('notify');
        $(this).addClass("active");
        $(".list-group")
            .children(".list-group-item")
            .not(this)
            .removeClass("active");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });
        $(".mail-detail-div").waitMe({
            effect: "stretch",
            waitTime: 2000,
            onClose: function() {
                $(".send_type span").remove();
                $(".mail_uname span").remove();
                $(".mail_from span").remove();
                $(".mail_to span").remove();
                $(".mail_date_time span").remove();
                $(".mail_body div").remove();
                $.post(url() + "/mail_detail_show", { id: mail_id }, function(e) {
                    // $(".clk-mail").removeClass("mail_un_read");
                    $(".mail-view").removeClass("d-none");
                    $(".send_type").append("<span>" + e.send_type + "</span>");
                    $(".mail_uname").append(
                        "<span>Dear " + e.user_name + ",</span>"
                    );
                    $(".mail_from").append(
                        "<span>" + e.sender_name + " " + e.from + "</span>"
                    );
                    $(".mail_to").append("<span>" + e.to + "</span>");
                    $(".mail_date_time").append(
                        "<span>" + e.date + " " + e.time + "</span>"
                    );
                    $(".mail_body").append("<div>" + e.mail_body + "</div>");
                });
            }
        });
    });

    $('#filter_div_state').on('change', function() {
        var allId = $(this).val();
        var result= allId.split("-")
        if (result[0] == "div") {
            
            $.ajax({
                type:'POST',
                url:url()+ '/filterDivisionState',
                data:{div_state:result[1]},
                success:function(data){
                    console.log(data);
                    $("#filter_div_state").html(data.output);
                }
            });
        } 
        if (result[0] == "dis") {
            
            $.ajax({
                type:'POST',
                url:url()+ '/filterDistrict',
                data:{district:result[1]},
                success:function(data){
                    $('#filter_div_state').prop('name', 'district_id');
                    $("#filter_div_state").html(data.output);
                    $("#hiddenData").html(data.hidden);
                }
            });
        }
        if (result[0] == "town") {
            
            $.ajax({
                type:'POST',
                url:url()+ '/filterTownship',
                data:{township:result[1]},
                success:function(data){
                    $('#filter_div_state').prop('name', 'township_id');
                    $("#filter_div_state").html(data.output);
                    $("#hiddenData").html(data.hidden);
                }
            });
        } 
    });

    $('#myImg').on('show.bs.modal', function(e) {
        var img = $(e.relatedTarget).attr('src');
        var cap = $(e.relatedTarget).attr('alt');
        // $(this).find('.modal-body').text('<img src="' + img + '" alt="' + cap + '"><p><strong>' + cap + '</strong></p>');
        $(this).find('.modal-body img').attr('src', img);
        $(this).find('.modal-body img').attr('alt', cap);
        $(this).find('.modal-body p').text(cap);
        console.log(img + ' /// ' + cap);
    });

    $("#string_change_yes").on("ifChecked", function() {
        $("#string_change_type_length").removeAttr("disabled");
    });
    $("#string_change_yes").on("ifUnchecked", function() {
        $("#string_change_type_length").attr("disabled", true);
        // $("#string_change_type_length").val("");
    });

    $("#capacitor_bank_yes").on("ifChecked", function() {
        $("#capacitor_bank_amt").removeAttr("disabled");
    });
    $("#capacitor_bank_yes").on("ifUnchecked", function() {
        $("#capacitor_bank_amt").attr("disabled", true);
    });

    /* lock user */
    $('.sa-btn-lock').click(function(){
        var id = $(this).data("id");
        status = $(this).data("status");
        chk_mm = false;
        if ($(this).hasClass("mm")) {
            chk_mm = true;
            // $(".sweet-alert").addClass("mm");
        }
        swal({
            title: "Are you sure to ban this account?",   
            text: "",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Sure!",   
            closeOnConfirm: false 
        }, function(){
            $.post(url() + "/lock_account", { id: id, status: status }, function() {
                $(".status"+id).html('<span class="badge badge-danger">BANNED</span>');
                $('.btn'+id+' .sa-btn-lock').addClass("d-none");
                $('.btn'+id+' .sa-btn-unlock').removeClass("d-none");
            });
            swal("Banned!", "You have changed this account disabled!", "success"); 
        });
    });
    /* unlock user */
    $('.sa-btn-unlock').click(function(){
        var id = $(this).data("id");
        status = $(this).data("status");
        chk_mm = false;
        if ($(this).hasClass("mm")) {
            chk_mm = true;
            // $(".sweet-alert").addClass("mm");
        }
        swal({
            title: "Are you sure to be active this account?",   
            text: "",   
            type: "success",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Sure!",   
            closeOnConfirm: false 
        }, function(){
            $.post(url() + "/lock_account", { id: id, status: status }, function() {
                $(".status"+id).html('<span class="badge badge-success">ACTIVE</span>');
                $('.btn'+id+' .sa-btn-unlock').addClass("d-none");
                $('.btn'+id+' .sa-btn-lock').removeClass("d-none");
            });
            swal("Gottcha!", "You have changed this account active!", "success"); 
        });
    });
    /* lock or unlock user */
    
});

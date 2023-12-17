! function(a) {
    function e(n) { if (t[n]) return t[n].exports; var i = t[n] = { i: n, l: !1, exports: {} }; return a[n].call(i.exports, i, i.exports, e), i.l = !0, i.exports }
    var t = {};
    e.m = a, e.c = t, e.d = function(a, t, n) { e.o(a, t) || Object.defineProperty(a, t, { configurable: !1, enumerable: !0, get: n }) }, e.n = function(a) { var t = a && a.__esModule ? function() { return a.default } : function() { return a }; return e.d(t, "a", t), t }, e.o = function(a, e) { return Object.prototype.hasOwnProperty.call(a, e) }, e.p = "", e(e.s = 175)
}({
    175: function(a, e, t) { a.exports = t(176) },
    176: function(a, e) {
        appealUiUtils = a.exports = {
            mobileCourtCaseNo: "",
            offenderName: "",
            initialNote: "",
            initialNoteReplaceParamDate: "তারিখে",
            initialNoteReplaceParamOrg: "প্রতিষ্ঠানের নাম",
            initialNoteReplaceParamDefaulter: "খাতকের নাম",
            initialNoteReplaceParamCompany: "১০(ক)",
            initialNoteReplaceParamAmount: "টাকার পরিমাণ",
            initialNoteReplaceParamDm: "জনাব",
            trialInitialNoteText: "সার্টিফিকেট ধারক উপস্থিত/অনুপস্থিত। সার্টিফিকেট খাতক উপস্থিত/অনুপস্থিত। ১০(ক) ধারার নোটিশ জারি হয়েছে/হয়নি। নোটিশ জারি অন্তে এস আর ফেরত পাওয়া গিয়েছে/যায়নি। \n\nদেখলাম।",
            cloneNomineeForm: $("#nomineeInfo").clone(),
            cloneIndex: $(".nomineeInfo").length + 1,
            regex: /^(.+?)(\d+)$/i,
            token: $("meta[name=csrf-token]").attr("content"),
            addMoreNomineeInfo: function() {
                var a = appealUiUtils.cloneNomineeForm.clone(!0),
                    e = appealUiUtils.cloneIndex,
                    t = appealUiUtils.regex;
                a.find("input:text,input:checkbox, input:radio,input:hidden, select, table,div,textarea,a,img,button,span").each(function() {
                    var a = this.id || "",
                        n = this.name || "",
                        i = this.href || "",
                        l = n.replace(/citizen\[5][^]\d+]/, "citizen[5][" + [e] + "]");
                    this.name = l;
                    o = a.match(t) || [];
                    3 == o.length && (this.id = o[1] + e);
                    var o;
                    3 == (o = i.match(t) || []).length && (this.href = o[1] + e)
                }).end().appendTo("#accordion");
                return $(".slNo:last").html(e), appealUiUtils.cloneIndex++, !1
            },
            deletNomineeInfo: function() {
                if (appealUiUtils.cloneIndex > 2) return $(".nomineeInfo:last").remove(), appealUiUtils.cloneIndex--, !1;
                $.alert("অন্তত একটি উত্তরাধিকারীর তথ্য দিতে হবে। ", "সর্তকিকরন ম্যাসেজ")
            },
            setInitialTrialOrderText: function(a) {
                var e = "";
                e = a || appealUiUtils.trialInitialNoteText, $("#note").text(e)
            },
            validateAmount: function(a) {
                var e = $(a).val();
                e.match("^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$") ? ($("#totalLoanAmountText").val(appealUiUtils.convertNumberToWords(languageSelector.toEnglish(e))), $(a).val(languageSelector.toEnglish(e)), appealUiUtils.changeInitialNote()) : ($(a).val(""), $.alert("অর্থদণ্ড শুধুমাত্র সংখ্যায় হবে!", "সর্তকিকরন ম্যাসেজ"))
            },
            validatePaymentAmount: function(a) {
                var e = $(a).val();
                if (e.match("^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$")) {
                    var t = languageSelector.toEnglish(e),
                        n = $("#dueAmountValue").val();
                    $(a).val(t), parseInt(t) > parseInt(n) && ($(a).val(""), $.alert("আদায় কৃত অর্থের পরিমাণ বকেয়া অর্থের পরিমাণ থেকে কম হতে হবে!", "সর্তকিকরন ম্যাসেজ"))
                } else $(a).val(""), $.alert("অর্থ শুধুমাত্র সংখ্যায় হবে!", "সর্তকিকরন ম্যাসেজ")
            },
            validateAuctionSaleAmount: function(a) {
                var e = $(a).val();
                if (e.match("^[0-9]*(০|১|২|৩|৪|৫|৬|৭|৮|৯|)*$")) {
                    var t = languageSelector.toEnglish(e);
                    $("#dueAmountValue").val();
                    $(a).val(t)
                } else $(a).val(""), $.alert("অর্থ শুধুমাত্র সংখ্যায় হবে!", "সর্তকিকরন ম্যাসেজ")
            },
            convertNumberToWords: function(a) {
                var e = ["", "এক", "দুই", "তিন", "চার", "পাঁচ", "ছয়", "সাত", "আট", "নয়", "দশ", "এগার", "বার", "তের", "চৌদ্দ", "পনের", "ষোল", "সতের", "আঠার", "ঊনিশ", "বিশ", "একুশ", "বাইশ", "তেইশ", "চব্বিশ", "পঁচিশ", "ছাব্বিশ", "সাতাশ", "আঠাশ", "ঊনত্রিশ", "ত্রিশ", "একত্রিশ", "বত্রিশ", "তেত্রিশ", "চৌত্রিশ", "পঁয়ত্রিশ", "ছত্রিশ", "সাঁইত্রিশ", "আটত্রিশ", "ঊনচল্লিশ", "চল্লিশ", "একচল্লিশ", "বিয়াল্লিশ", "তেতাল্লিশ", "চুয়াল্লিশ", "পঁয়তাল্লিশ", "ছেচল্লিশ", "সাতচল্লিশ", "আটচল্লিশ", "ঊনপঞ্চাশ", "পঞ্চাশ", "একান্ন", "বায়ান্ন", "তিপ্পান্ন", "চুয়ান্ন", "পঞ্চান্ন", "ছাপ্পান্ন", "সাতান্ন", "আটান্ন", "ঊনষাট", "ষাট", "একষট্টি", "বাষট্টি", "তেষট্টি", "চৌষট্টি", "পঁয়ষট্টি", "ছেষট্টি", "সাতষট্টি", "আটষট্টি", "ঊনসত্তর", "সত্তর", "একাতর", "বাহাত্তর", "তিয়াত্তর", "চুয়াত্তর", "পঁচাত্তর", "ছিয়াত্তর", "সাতাত্তর", "আটাত্তর", "ঊনআশি", "আশি", "একাশি", "বিরাশি", "তিরাশি", "চুরাশি", "পঁচাশি", "ছিয়াশি", "সাতাশি", "আটাশি", "ঊননব্বই", "নব্বই", "একানব্বই", "বিরানব্বই", "তিরানব্বই", "চুরানব্বই", "পঁচানব্বই", "ছিয়ানব্বই", "সাতানব্বই", "আটানব্বই", "নিরানব্বই"],
                    t = (a = a.toString()).split("."),
                    n = "",
                    i = "",
                    l = t[0];
                if ("0" !== l && (n = appealUiUtils.toWord(l, e)), 2 === t.length) {
                    var o = t[1];
                    i = appealUiUtils.toWord(o, e), n += "" !== n ? " দশমিক " + i : "দশমিক " + i
                }
                return n
            },
            toWord: function(a, e) {
                var t = a.length,
                    n = "";
                if (t <= 9) {
                    for (var i = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0), l = new Array, o = 0; o < t; o++) l[o] = a.substr(o, 1);
                    for (var o = 9 - t, r = 0; o < 9; o++, r++) i[o] = l[r];
                    for (var o = 0, r = 1; o < 9; o++, r++) 0 != o && 2 != o && 4 != o && 7 != o || (1 == i[o] ? (i[r] = 10 + parseInt(i[r]), i[o] = 0) : 2 == i[o] ? (i[r] = 20 + parseInt(i[r]), i[o] = 0) : 3 == i[o] ? (i[r] = 30 + parseInt(i[r]), i[o] = 0) : 4 == i[o] ? (i[r] = 40 + parseInt(i[r]), i[o] = 0) : 5 == i[o] ? (i[r] = 50 + parseInt(i[r]), i[o] = 0) : 6 == i[o] ? (i[r] = 60 + parseInt(i[r]), i[o] = 0) : 7 == i[o] ? (i[r] = 70 + parseInt(i[r]), i[o] = 0) : 8 == i[o] ? (i[r] = 80 + parseInt(i[r]), i[o] = 0) : 9 == i[o] && (i[r] = 90 + parseInt(i[r]), i[o] = 0));
                    for (var p = "", o = 0; o < 9; o++) 0 != (p = i[o]) && (n += e[p] + ""), (1 == o && 0 != p || 0 == o && 0 != p && 0 == i[o + 1]) && (n += " কোটি "), (3 == o && 0 != p || 2 == o && 0 != p && 0 == i[o + 1]) && (n += " লাখ "), 5 == o && 0 != p || 4 == o && 0 != p && 0 == i[o + 1] ? n += " হাজার " : 6 == o && 0 != p && (n += "শ ");
                    n = n.split("  ").join(" ")
                }
                return n
            },
            appendUnderUpazillaBlock: function(a, e) {
                var t = "",
                    n = '<div class="col-md-6">  <div class="form-group"> ';
                $("#underZillaLoc").empty(), "THANA" == a ? (n += '<label for="thana" class="control-label">থানা</label>  ', n += "INITIATE" == e ? '<select  class="selectDropdown form-control select2" id="thana" name="thana">  </select>  ' : '<span  class="form-control" id="thana" name="thana">  </span>  ') : "UPAZILLA" == a ? n += '<label for="upazilla" class="control-label"> উপজেলা</label>  ' + "<span upazillaId='' id='upazilla' class=\"form-control\" name='upazilla' ></span>" : "CITYCORPORATION" == a && (n += '<label for="citycorporation" class="control-label"> সিটি করপোরেশন</label>  ' + "<span citycorporationId='' class=\"form-control\" id='citycorporation' name='citycorporation'></span>"), t = n + "</div> </div> ", $("#locationType").val(a), $("#underZillaLoc").append(t)
            },
            appendApplicantLocationUnderUpazillaBlock: function(a, e) {
                var t = "",
                    n = '<div class="col-md-6">  <div class="form-group"> ';
                $("#applicantUnderZillaLoc").empty(), "THANA" == a ? (n += '<label for="applicantThana" class="control-label">থানা</label>  ', n += "INITIATE" == e ? '<select  class="selectDropdown form-control select2" id="applicantThana" name="applicantThana">  </select>  ' : '<span  class="form-control" id="applicantThana" name="applicantThana">  </span>  ') : "UPAZILLA" == a ? n += '<label for="applicantUpazilla" class="control-label"> উপজেলা</label>  ' + "<span applicantUpazillaId='' id='applicantUpazilla' class=\"form-control\" name='applicantUpazilla' ></span>" : "CITYCORPORATION" == a && (n += '<label for="applicantCitycorporation" class="control-label"> সিটি করপোরেশন</label>  ' + "<span applicantCitycorporationId='' class=\"form-control\" id='applicantCitycorporation' name='applicantCitycorporation'></span>"), t = n + "</div> </div> ", $("#applicantLocationType").val(a), $("#applicantUnderZillaLoc").append(t)
            },
            sameAsOffender: function(a) {
                var e = $("#offenderName_1").val(),
                    t = $("#offenderPhn_1").val(),
                    n = $("#offenderNid_1").val(),
                    i = $("#offenderGender_1").val();
                $(a).is(":checked") ? ($("#appealerName_1").val(e), $("#appealerPhn_1").val(t), $("#appealerNid_1").val(n), $("#appealerGender_1").val(i).trigger("change")) : ($("#appealerName_1").val(""), $("#appealerPhn_1").val(""), $("#appealerNid_1").val(""), $("#appealerGender_1").val("").trigger("change"))
            },
            checkCaseEntryType: function() { "OLD" === $("input[type='radio'].caseEntryType:checked").val() ? $("#prevCaseDiv").removeClass("hidden") : ($("#previouscaseNo").val(""), $("#prevCaseDiv").addClass("hidden"), $("#initialNoteDiv").removeClass("hidden")), appealUiUtils.setInitialNoteTemplate("", "", "", "") },
            changeInitialNote: function() {
                var a = languageSelector.toBangla($("#caseDate").val()),
                    e = $("#applicantOrganization_1").val(),
                    t = $("#defaulterName_1").val(),
                    n = $("#totalLoanAmount").val(),
                    i = $("#totalLoanAmountText").val(),
                    l = "";
                appealUiUtils.initialNote = $("#note").val();
                var o = "",
                    r = "",
                    p = "",
                    d = "",
                    c = "",
                    s = $("input[name=applicantType]:checked", "#appealForm").val();
                a && (o = a ? a + " তারিখে" : "", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamDate, o), appealUiUtils.initialNoteReplaceParamDate = o, $("#note").val(l), appealUiUtils.initialNote = l), n && (d = n ? languageSelector.toBangla(n) + " (" + i + ")" : "", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamAmount, d), appealUiUtils.initialNoteReplaceParamAmount = d, appealUiUtils.initialNote = l), e && (r = e || "", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamOrg, r), appealUiUtils.initialNoteReplaceParamOrg = r, appealUiUtils.initialNote = l), t && (p = t || "", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamDefaulter, p), appealUiUtils.initialNoteReplaceParamDefaulter = p, appealUiUtils.initialNote = l), "BANK" == s ? (c = "১০(ক) ", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamCompany, c), appealUiUtils.initialNoteReplaceParamCompany = c, appealUiUtils.initialNote = l) : (c = "৭ ", l = appealUiUtils.initialNote.replace(appealUiUtils.initialNoteReplaceParamCompany, c), appealUiUtils.initialNoteReplaceParamCompany = c, appealUiUtils.initialNote = l), $("#note").val(l)
            },
            changeInitiateNoteFromDm: function() {
                if ($("#admList").val()) {
                    appealUiUtils.initialNote = $("#note").val();
                    var a = $("#admList option:selected").text(),
                        e = a ? "জনাব " + a : "",
                        t = appealUiUtils.initialNote.replace(new RegExp(appealUiUtils.initialNoteReplaceParamDm, "gi"), e);
                    appealUiUtils.initialNoteReplaceParamDm = e, $("#note").val(t)
                }
            },
            setInitialNoteTemplate: function(a, e, t, n) { $("#note").val("প্রতিষ্ঠানের নাম হতে তারিখে খাতকের নাম এর নিকট হতে টাকার পরিমাণ টাকা আদায়ের জন্য সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা মতে একটি অনুরোধপত্র পাওয়া গিয়েছে। \n\nদেখলাম। দাবী আদায়যোগ্য বিবেচিত হওয়ায় ১০ নং রেজিস্টার বহিতে লিপিবদ্ধ করে সার্টিফিকেট রিকুইজিশনে স্বাক্ষর করা হল। সার্টিফিকেট খাতকের প্রতি ১০(ক) ধারার নোটিশ জারি করা হোক। আগামি (০১ মাসের  মধ্যে) প্রসেস সার্ভারকে নোটিশ জারির এস আর দাখিল করার জন্য বলা হল।") },
            checkAppealStatus: function(a) { "DRAFT" != a.appeal_status && "SEND_TO_GCO" != a.appeal_status || $("#printReport").remove() },
            setIframe: function(a, e) {
                $("#iFrameContainer").show();
                var t = $("#mobile_url").val() + "/mobile/showFileForCaseNumberCriminal/" + a + "/" + e;
                $("#frameMobile").attr("src", t)
            },
            appendNotes: function(a, e, t) {
                var n = "",
                    i = e.length,
                    l = "",
                    o = e.length,
                    r = "";
                $.each(e, function(a, e) {
                    var i = [];
                    $.each(t, function(a, t) { e.cause_list_id === t.cause_list_id && i.push(t) });
                    var p = "";
                    "" != i && (p = appealUiUtils.appendAttachments(i)), a > 0 && (l = "");
                    var d = languageSelector.toBangla(e.conduct_date) + "  তারিখ এর আদেশ";
                    a === o - 1 && (r = "<button style='float: right; margin: 10px;' type='button' class='btn btn-danger' onclick='appealUiUtils.lastOrderDelete(" + e.cause_list_id + "," + e.appeal_id + ");' > বাতিল করুন</button>"), n += '<section class="panel panel-primary">       <div class="panel-heading" role="tab" id="headOne">            <h4 class="panel-title">             <a id=\'noteDate_' + a + '\' class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collaps_' + a + '" aria-expanded="false"> ' + d + '<i class="fa fa-angle-down pull-right"></i></a>             </h4>       </div>       <div id="collaps_' + a + '" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">           <div class="panel-body cpv p-10">               <div >' + e.order_text + "</div>           </div>" + p + r + "       </div>    </section>"
                }), $(".notesDiv").append(n), $("#collapse_" + (i - 1)).collapse("show")
            },
            lastOrderDelete: function(a, e) { $.confirm({ resizable: !1, height: 250, width: 400, modal: !0, title: "আদেশ বাতিল", titleClass: "modal-header", content: " আপনি কি নিশ্চিত?", buttons: { "না": function() {}, "হ্যাঁ": function() { $("#loadingModal").show(), appealUiUtils.deleteOrder(a, e).done(function(a, e, t) { $("#loadingModal").hide(), "true" == a.flag ? ($.alert(" আপনার শেষ আদেশ টি বাতিল করা হয়েছে", "অবহিতকরণ বার্তা"), setTimeout(function() { location.reload() }, 3e3)) : $.alert("ত্রুটি", "অবহিতকরণ বার্তা") }).fail(function() { $("#loadingModal").hide(), $.alert("ত্রুটি", "অবহিতকরণ বার্তা") }) } } }) },
            deleteOrder: function(a, e) { return $.ajax({ headers: { "X-CSRF-Token": this.token }, url: "/appeal/delete/lastOrder", method: "post", data: { causeListId: a, appealId: e }, dataType: "json" }) },
            appendAttachments: function(a) {
                var e = 1,
                    t = "",
                    n = '<div class="panel-body cpv p-10">   <label> সংযুক্ত  ফাইল </label>   <table class="table table-bordered table-condensed margin-0">';
                return $.each(a, function(a, i) { t = languageSelector.toBangla(e), n += '<tr>   <td class="wide-70px">' + t + " - নম্বর :   </td>   <td>" + i.file_category + '   </td>   <td class="wide-30px text-nowrap">       <a title=" ডাউনলোড করতে ক্লিক করুন " href="/ECOURT/' + i.file_path + i.file_name + '" class="btn-link btn-md" download>           <i class="fa fa-download"></i> ডাউনলোড       </a>   </td></tr>', e++ }), n += "</table></div>"
            },
            updateNote: function(a) {
                if (1 == $(a).is(":checked")) {
                    var e = $(a).attr("desc");
                    appealUiUtils.noteAdd(e)
                }
                19 == $(a).val() && $("#paymentStatus").val("PAYMENT_REGULAR"), 16 == $(a).val() && $("#paymentStatus").val("PAYMENT_AUCTION"), 15 == $(a).val() && $("#paymentStatus").val("PAYMENT_INSTALLMENT")
            },
            trailDateAdd: function() {
                var a = " \nপরবর্তী তারিখ: " + languageSelector.toBangla($("#trialDate").val());
                appealUiUtils.noteAdd(a)
            },
            attendanceDateChange: function() {
                var a = $("#conductDate").val();
                $(".citizenAttendanceApplicantAttendanceDate").val(a)
            },
            noteAdd: function(a) {
                var e = $("#note").val() + "\n" + a;
                $("#note").val(e)
            },
            appendShortOrderCheckBox: function(a, e) {
                var t = "",
                    n = "";
                $(".orderCheckBox").empty(), $.each(a, function(a, e) { t += "<label class='checkbox'><input  value=\"" + e.id + '" type="checkbox" class="shortOrderCheckBox" onchange="appealUiUtils.updateNote(this)" name="shortOrder[' + a + ']" id="shortOrder_' + e.id + '" desc="' + e.delails + '" />' + e.case_short_decision + "</label>" }), $(".orderCheckBox").append(t), e.length > 0 && $.each(e, function(a, e) { n = "#shortOrder_" + e.case_shortdecision_id, $(n).attr("checked", "checked") })
            },
            populateAppealPlaceOfOccuranceLocation: function(a, e) { $("#zilla").text(a.zilla_name), $("#zilla").attr("zillaId", a.zilla_id), "THANA" == a.location_type || "METROPOLITAN" == a.location_type ? appealUiUtils.appendUnderUpazillaBlock("THANA", e) : "UPAZILLA" == a.location_type ? (appealUiUtils.appendUnderUpazillaBlock("UPAZILLA", e), $("#upazilla").text(a.upazilla_name), $("#upazilla").attr("upazillaId", a.upazilla_id)) : "CITYCORPORATION" == a.location_type && (appealUiUtils.appendUnderUpazillaBlock("CITYCORPORATION", e), $("#citycorporation").text(a.citycorporation_name), $("#citycorporation").attr("citycorporationId", a.citycorporation_id)) },
            populateOffenderLocation: function(a, e) { $("#applicantDivision").text(a.division_name), $("#applicantDivision").attr("applicantDivisionId", a.division_id), $("#applicantZilla").text(a.zilla_name), $("#applicantZilla").attr("applicantZillaId", a.zilla_id), "THANA" == a.location_type || "METROPOLITAN" == a.location_type ? (appealUiUtils.appendApplicantLocationUnderUpazillaBlock("THANA", e), $("#applicantThana").text(a.thana_name), $("#applicantThana").attr("applicantThanaId", a.thana_id)) : "UPAZILLA" == a.location_type ? (appealUiUtils.appendApplicantLocationUnderUpazillaBlock("UPAZILLA", e), $("#applicantUpazilla").text(a.upazilla_name), $("#applicantUpazilla").attr("upazillaId", a.upazilla_id)) : "CITYCORPORATION" == appeal.location_type && (appealUiUtils.appendApplicantLocationUnderUpazillaBlock("CITYCORPORATION", e), $("#applicantCitycorporation").text(a.citycorporation_name), $("#applicantCitycorporation").attr("citycorporationId", a.citycorporation_id)) },
            disableDivAndZillaDropDown: function() { $("#ddlDivision999").attr("disabled", "disabled"), $("#ddlZilla999").attr("disabled", "disabled") },
            disableLocationTypeDropDown: function() { $("input[name=locationType]").attr("disabled", !0), $("#ddlunderZillaLoc999").attr("disabled", "disabled") },
            disableApplicantDivAndZillaDropDown: function() { $("#ddlDivision1").attr("disabled", "disabled"), $("#ddlZilla1").attr("disabled", "disabled") },
            disableApplicantLocationTypeDropDown: function() { $("input[name=offenderLocationType]").attr("disabled", !0), $("#ddlunderZillaLoc1").attr("disabled", "disabled") },
            populateAppealInitiateInfo: function(a) {
                var e = a.data.appeal,
                    t = a.data.applicantCitizen,
                    n = a.data.defaulterCitizen,
                    i = a.data.guarantorCitizen,
                    l = a.data.lawerCitizen,
                    o = a.data.nomineeCitizen,
                    r = a.data.policeCitizen,
                    p = e.case_no,
                    d = e.case_date,
                    c = e.law_section;
                $("#caseNo").text(p), $("#caseDate").val(d), $("#lawSection").val(c),
                    $("#totalLoanAmount").val(e.loan_amount), $("#totalLoanAmountText").val(e.loan_amount_text),
                    "BANK" == e.applicant_type ? $("#applicantTypeBank").attr("checked", !0) : ($("#applicantTypeBank").attr("checked", !1), $("#applicantTypeOther").attr("checked", !0)), $("#applicantName_1").val(t.citizen_name), $("#applicantPhn_1").val(t.citizen_phone_no), $("#applicantNid_1").val(t.citizen_NID), $("#applicantFather_1").val(t.father), $("#applicantMother_1").val(t.mother), $("#applicantDesignation_1").val(t.designation), $("#applicantOrganization_1").val(t.organization), $("#applicantPresentAddree_1").val(t.present_address), $("#applicantId_1").val(t.id), $("#applicantGender_1").val(t.citizen_gender), $("#applicantGender_1").select2(), $("#defaulterName_1").val(n.citizen_name), $("#defaulterPhn_1").val(n.citizen_phone_no), $("#defaulterNid_1").val(n.citizen_NID), $("#defaulterFather_1").val(n.father), $("#defaulterMother_1").val(n.mother), $("#defaulterDesignation_1").val(n.designation), $("#defaulterOrganization_1").val(n.organization), $("#defaulterPresentAddree_1").val(n.present_address), $("#defaulterId_1").val(n.id), $("#defaulterGender_1").val(n.citizen_gender), $("#defaulterGender_1").select2(), $("#guarantorName_1").val(i.citizen_name), $("#guarantorPhn_1").val(i.citizen_phone_no), $("#guarantorNid_1").val(i.citizen_NID), $("#guarantorFather_1").val(i.father), $("#guarantorMother_1").val(i.mother), $("#guarantorDesignation_1").val(i.designation), $("#guarantorOrganization_1").val(i.organization), $("#guarantorId_1").val(i.id), $("#guarantorPresentAddree_1").val(i.present_address), $("#guarantorGender_1").val(i.citizen_gender), $("#guarantorGender_1").select2(), $("#lawyerName_1").val(l.citizen_name), $("#lawyerPhn_1").val(l.citizen_phone_no), $("#lawyerNid_1").val(l.citizen_NID), $("#lawyerFather_1").val(l.father), $("#lawyerMother_1").val(l.mother), $("#lawyerDesignation_1").val(l.designation), $("#lawyerOrganization_1").val(l.organization), $("#lawyerPresentAddree_1").val(l.present_address), $("#lawyerId_1").val(l.id), $("#lawyerGender_1").val(l.citizen_gender), $("#lawyerGender_1").select2(), $.each(o, function(a, e) {
                        var t = a + 1;
                        appealUiUtils.cloneIndex <= t && appealUiUtils.addMoreNomineeInfo(), $("#nomineeName_" + t).val(e.citizen_name), $("#nomineePhn_" + t).val(e.citizen_phone_no), $("#nomineeNid_" + t).val(e.citizen_NID), $("#nomineeFather_" + t).val(e.father), $("#nomineeMother_" + t).val(e.mother), $("#nomineeAge_" + t).val(e.age), $("#nomineePresentAddree_" + t).val(e.present_address), $("#nomineeId_" + t).val(e.id), $("#nomineeGender_" + t).val(e.citizen_gender).select2()
                    }), $("#policeName_1").val(r.citizen_name), $("#policePhn_1").val(r.citizen_phone_no), $("#policeNid_1").val(r.citizen_NID), $("#policeFather_1").val(r.father), $("#policeDesignation_1").val(r.designation), $("#policeEmail_1").val(r.email), $("#policeThana_1").val(r.thana), $("#policeUpazilla_1").val(r.upazilla), $("#policeId_1").val(r.id), $("#policeGender_1").val(r.citizen_gender), $("#policeGender_1").select2()
            },
            populateOffenderInfoFromMobileCourt: function(a) {
                a.name_bng && ($("#offenderName_1").val(a.name_bng), $("#offenderName_1").attr("readonly", !0)), a.mobile_no && ($("#offenderPhn_1").val(a.mobile_no), $("#offenderPhn_1").attr("readonly", !0)), a.national_id && ($("#offenderNid_1").val(a.national_id), $("#offenderNid_1").attr("readonly", !0)), a.gender ? ("পুরুষ" == a.gender ? $("#offenderGender_1").val("MALE") : $("#offenderGender_1").val("FEMALE"), $("#offenderGender_1").attr("disabled", "disabled")) : $("#offenderGender_1").select2();
                var e = "";
                e = "METROPOLITAN" == a.location_type ? "THANA" : a.location_type, eMobileLocation.populateLocation(1, e, a.divid, a.zillaId, a.upazilaid, a.geo_citycorporation_id, a.geo_thana_id), $("#locationTypeVal1").val(a.location_type), appealUiUtils.disableApplicantDivAndZillaDropDown(), appealUiUtils.disableApplicantLocationTypeDropDown()
            },
            appealFormClear: function() { $(":input", "#appealForm").not(":button, :submit, :reset, :hidden").not("textarea").val("").removeAttr("checked").removeAttr("readonly").removeAttr("disabled").removeAttr("selected") },
            disableOffenderInfo: function() { $("#offenderName").attr("readonly", !0), $("#offenderPhn").attr("readonly", !0), $("#offenderNid").attr("readonly", !0), $("#offenderGender").attr("disabled", "disabled") },
            disableLawInfo: function() { for (var a = $(".criminal_laws").length, e = 1; e <= a; e++) $("#ddlLaw" + e).attr("disabled", "disabled"), $("#ddlSection" + e).attr("disabled", "disabled"), $("#c_a_button_" + e).hide(), $("#c_r_button_" + e).hide() },
            showAddRemoveLawButton: function() { for (var a = $(".criminal_laws").length, e = 1; e <= a; e++) $("#c_a_button_" + e).show(), $("#c_r_button_" + e).show() },
            disableMobileCourtInfo: function(a) { appealUiUtils.disableLawInfo(), appealUiUtils.disableOffenderInfo() },
            convertMaleFemaleToBng: function(a) { var e = ""; return "MALE" == a ? e = "পুরুষ" : "FEMALE" == a && (e = "নারী"), e },
            getPaymentInfo: function(a) { return $.ajax({ headers: { "X-CSRF-Token": this.token }, url: "/appeal/get/collectPayment", method: "POST", data: a, dataType: "json" }) },
            populateAppealSpanInfo: function(a) {
                var e = a.data.appeal,
                    t = a.data.applicantCitizen,
                    n = a.data.defaulterCitizen,
                    i = a.data.guarantorCitizen,
                    l = a.data.lawerCitizen,
                    o = a.data.nomineeCitizen,
                    r = a.data.policeCitizen,
                    p = e.case_no,
                    d = e.case_date.split("-"),
                    c = d[2] + "-" + d[1] + "-" + d[0].slice(-4),
                    s = languageSelector.toBangla(c),
                    u = e.law_section;
                e.prev_case_no ? $("#previouscaseNo").text(e.prev_case_no) : $("#prevCaseDiv").addClass("hidden"), "OLD" == e.case_entry_type ? $("#caseEntryType").text("পুরাতন মামলা") : $("#caseEntryType").text("নতুন মামলা"), null != e.payment_status && ($("#paymentInformation").removeAttr("hidden"), appealUiUtils.getPaymentInfo({ appealId: e.id }).done(function(a, e, t) {
                    $("#totalLoan").text(a.totalLoanAmount + " টাকা"), $("#dueAmount").text(a.totalDueAmount + " টাকা");
                    var n = a.totalLoanAmount - a.totalDueAmount;
                    $("#totalPaidAmount").text(n + " টাকা"), $("#dueAmountValue").val(a.totalDueAmount), "PAYMENT_AUCTION" == a.paymentStatus && ($("#auctionBlock").removeAttr("hidden"), $("#auctionSale").text(a.totalAuctionSale + " টাকা"))
                })), $("#caseNo").text(p), $("#caseDate").text(s), $("#lawSection").text(u), $("#totalLoanAmount").text(e.loan_amount), $("#totalLoanAmountText").text(e.loan_amount_text), "BANK" == e.applicant_type ? $("#applicantType").text("ব্যাংক") : $("#applicantType").text("অন্যান্য কোম্পানি"), $(".citizenAttendanceAppealId").val(e.id), $("#applicantName").text(t.citizen_name), $("#applicantDesignation").text(t.designation), $("#citizenAttendanceApplicantCitizenId").val(t.id), $("#applicantName_1").text(t.citizen_name), $("#applicantPhn_1").text(t.citizen_phone_no), $("#applicantNid_1").text(t.citizen_NID), $("#applicantFather_1").text(t.father), $("#applicantMother_1").text(t.mother), $("#applicantDesignation_1").text(t.designation), $("#applicantOrganization_1").text(t.organization), $("#applicantPresentAddree_1").text(t.present_address), $("#applicantId_1").text(t.id), $("#applicantGender_1").text(appealUiUtils.convertMaleFemaleToBng(t.citizen_gender)), $("#defaulterName").text(n.citizen_name), $("#defaulterDesignation").text(n.designation), $("#citizenAttendanceDefaulterCitizenId").val(n.id), $("#defaulterName_1").text(n.citizen_name), $("#defaulterPhn_1").text(n.citizen_phone_no), $("#defaulterNid_1").text(n.citizen_NID), $("#defaulterFather_1").text(n.father), $("#defaulterMother_1").text(n.mother), $("#defaulterDesignation_1").text(n.designation), $("#defaulterOrganization_1").text(n.organization), $("#defaulterPresentAddree_1").text(n.present_address), $("#defaulterId_1").text(n.id), $("#defaulterGender_1").text(appealUiUtils.convertMaleFemaleToBng(n.citizen_gender)), $("#guarantorName_1").text(i.citizen_name), $("#guarantorPhn_1").text(i.citizen_phone_no), $("#guarantorNid_1").text(i.citizen_NID), $("#guarantorFather_1").text(i.father), $("#guarantorMother_1").text(i.mother), $("#guarantorDesignation_1").text(i.designation), $("#guarantorOrganization_1").text(i.organization), $("#guarantorId_1").text(i.id), $("#guarantorPresentAddree_1").text(i.present_address), $("#guarantorGender_1").text(appealUiUtils.convertMaleFemaleToBng(i.citizen_gender)), $("#lawyerName_1").text(l.citizen_name), $("#lawyerPhn_1").text(l.citizen_phone_no), $("#lawyerNid_1").text(l.citizen_NID), $("#lawyerFather_1").text(l.father), $("#lawyerMother_1").text(l.mother), $("#lawyerDesignation_1").text(l.designation), $("#lawyerOrganization_1").text(l.organization), $("#lawyerPresentAddree_1").text(l.present_address), $("#lawyerId_1").text(l.id), $("#lawyerGender_1").text(appealUiUtils.convertMaleFemaleToBng(l.citizen_gender)), $.each(o, function(a, e) {
                    var t = a + 1;
                    appealUiUtils.cloneIndex <= t && appealUiUtils.addMoreNomineeInfo(), $("#nomineeName_" + t).text(e.citizen_name), $("#nomineePhn_" + t).text(e.citizen_phone_no), $("#nomineeNid_" + t).text(e.citizen_NID), $("#nomineeFather_" + t).text(e.father), $("#nomineeMother_" + t).text(e.mother), $("#nomineeAge_" + t).text(e.age), $("#nomineePresentAddree_" + t).text(e.present_address), $("#nomineeId_" + t).text(e.id), $("#nomineeGender_" + t).text(appealUiUtils.convertMaleFemaleToBng(e.citizen_gender))
                }), $("#policeName_1").text(r.citizen_name), $("#policePhn_1").text(r.citizen_phone_no), $("#policeNid_1").text(r.citizen_NID), $("#policeFather_1").text(r.father), $("#policeDesignation_1").text(r.designation), $("#policeEmail_1").text(r.email), $("#policeThana_1").text(r.thana), $("#policeUpazilla_1").text(r.upazilla), $("#policeId_1").text(r.id), $("#policeGender_1").text(appealUiUtils.convertMaleFemaleToBng(r.citizen_gender));
                var _ = a.data.appealCauseList.length,
                    m = ((d = a.data.appealCauseList[_ - 1].conduct_date.split("-"))[2], d[1], d[0].slice(-4), (d = a.data.appealCauseList[_ - 1].trial_date.split("-"))[2] + "-" + d[1] + "-" + d[0].slice(-4));
                $("#conductDate").val(m), $("#trialTime").val(a.data.appealCauseList[_ - 1].trial_time), $(".citizenAttendanceApplicantAttendanceDate").val(m)
            },
            setPreviousCourtInfo: function(a, e) { $("#emName").text(a), $("#previousCourtOrderText").text(e) },
            makeReadOnlyPreviousCourtInfo: function() { $("#emName").attr("readonly", "readonly"), $("#previousCourtOrderText").attr("readonly", "readonly") },
            hideTrialDate: function() { "1" != $("#appealDecision").val() ? ($("#trialDate").parent("div").hide(), $("#trialTime").parent("div").hide(), $("#conductDate").parent("div").hide(), $('label[for="trialDate"]').hide(), $('label[for="trialTime"]').hide(), $('label[for="conductDate"]').hide(), $(".resendToADM").hide()) : ($("#trialTime").parent("div").show(), $("#trialDate").parent("div").show(), $("#conductDate").parent("div").show(), $('label[for="trialDate"]').show(), $('label[for="trialTime"]').show(), $('label[for="conductDate"]').show(), $(".resendToADM").show()) },
            appendLawSectionSpan: function(a) {
                for (var e = "", t = 0; t < a.length; t++) e += '<div class="col-md-6"> <div class="form-group">     <label class="control-label"><span style="color:#FF0000">*</span>আইন</label>       <span class="form-control" >' + a[t].law_title + '</span> </div></div><div class="col-md-6"> <div class="form-group">     <label class="control-label"><span style="color:#FF0000">*</span>ধারা</label>        <span class="form-control" >' + a[t].section_title + "</span> </div></div>";
                $("#lawsBrokenSpan").append(e)
            },
            populateDropDown: function(a, e, t, n, i, l) { e.append('<option value="">' + t + "</option>"), "" != a && $.each(a, function(a, t) { e.append('<option value="' + t[i] + '">' + t[l] + "</option>") }), e.val(n) },
            setNoteInfo: function(a, e) {
                var t = "";
                t = "DRAFT" == e.appeal_status ? "" : "দেখলাম । আপিল নিষ্পত্তির জন্য বিজ্ঞ অতিরিক্ত জেলা ম্যাজিস্ট্রেট  জনাব  এর  আদালতে প্রেরণ করা  হল ।", $("#note").val(a[0].order_text + t), $("#noteId").val(a[0].id), 1 == e.is_available_in_mobile_court ? appealUiUtils.setIframe(e.mobile_court_case_no, e.criminal_id) : $("#iFrameContainer").hide()
            },
            setCauseListInfo: function(a) {
                var e = a[0].conduct_date.split("-"),
                    t = e[2] + "-" + e[1] + "-" + e[0].slice(-4),
                    n = (e = a[0].trial_date.split("-"))[2] + "-" + e[1] + "-" + e[0].slice(-4);
                $("#conductDate").val(t), $("#trialDate").val(n);
                var i = parseInt(a[0].trial_time.split(":")[0]),
                    l = a[0].trial_time.split(":")[1],
                    o = i > 12 ? "PM" : "AM",
                    r = (i > 12 ? i - 12 : i) + "";
                r.length < 2 && (r = "0" + r);
                var p = r + ":" + l + " " + o;
                $("#trialTime").val(p), $("#causeListId").val(a[0].id)
            },
            setLawAndSectionInfo: function(a) { for (var e = 1; e <= a.length; e++) lawSelector.init(e, a[e - 1].law_id, a[e - 1].section_id), e < a.length && lawInitiate.addNewLaw(!1) },
            setLocationInfo: function(a) { appealUiUtils.populateAppealPlaceOfOccuranceLocation(a, ""), $("#thana").text(a.thana_name) },
            appendRadioButton: function(a) {
                var e = "",
                    t = "";
                $("#criminalDiv").empty(), $.each(a, function(a, t) { e += '<input type="radio" name="criminal" id="criminal_' + t.id + '" value="' + t.id + '"> ' + t.name_bng + "  " }), t = '<div class="form-group"><label for="criminal" class="control-label">আসামির তালিকা</label><div class="form-group">' + e + '<button type="button" onclick="appealPopulate.searchByCaseNoAndCriminalId()" class="btn btn-primary btn-sm"> নির্বাচন  করুন </button></div></div>', $("#criminalDiv").append(t)
            },
            removeLawSectionDiv: function(a) { for (var e = a; e > 1; e--) $("#c-lawdiv_" + e).remove() },
            appendAttachmentsForViewAndDelete: function(a) {
                for (var e = '<div class="panel-body cpv p-10">   <table class="table table-bordered table-condensed margin-0">', t = 1, n = "", i = 0; i < a.length; i++) {
                    n = languageSelector.toBangla(t);
                    var l = a[i].id;
                    e += '<tr id="attachmentContainer_' + l + '">   <td class="wide-70px">' + n + " - নম্বর :   </td>   <td>" + a[i].file_category + '   </td>   <td class="wide-30px text-nowrap">       <a title=" অপসারণ  করতে ক্লিক করুন" onclick="appealUiUtils.deleteAttachmentByFileID(this,' + l + ')" class="btn-link btn-md" >           <i class="fa fa-remove"></i> অপসারণ       </a>   </td></tr>', t++
                }
                var o = '<div id="divImageListContainer" class="docs-pictures panel-body"><ul class="list-inline">' + (e += "</table></div>") + "</ul></div>";
                $("#AttachedFile").append('<div class="panel-heading"><h4 class="panel-title"> সংযুক্ত ফাইল </h4></div>').append(o)
            },
            appendAttachmentsForView: function(a) {
                for (var e = '<div class="panel-body cpv p-10">   <table class="table table-bordered table-condensed margin-0">', t = 1, n = 0; n < a.length; n++) {
                    a[n].id;
                    e += '<tr>   <td class="wide-70px">' + languageSelector.toBangla(t) + " - নম্বর :   </td>   <td>" + a[n].file_category + '   </td>   <td class="wide-30px text-nowrap">       <a title=" ডাউনলোড করতে ক্লিক করুন " href="/ECOURT/' + a[n].file_path + a[n].file_name + '" class="btn-link btn-md" download>           <i class="fa fa-download"></i> ডাউনলোড        </a>   </td></tr>', t++
                }
                var i = '<div id="divImageListContainer" class="docs-pictures panel-body"><ul class="list-inline">' + (e += "</table></div>") + "</ul></div>";
                $("#AttachedFile").append('<div class="panel-heading"><h4 class="panel-title">সংযুক্ত ফাইল</h4></div>').append(i)
            },
            deleteAttachmentByFileID: function(a, e) {
                var t = e;
                $.confirm({ resizable: !1, height: 250, width: 400, modal: !0, title: "ফাইল তথ্য", titleClass: "modal-header", content: "ফাইলটি ডিলিট করতে চান ?", buttons: { "না": function() {}, "হ্যাঁ": function() { $.ajax({ headers: { "X-CSRF-Token": this.token }, url: "/appeal/deleteFile", method: "GET", dataType: "json", data: { fileID: t }, success: function(a) { $.alert("ফাইল ডিলিট সম্পন্ন হয়েছে ।", "ধন্যবাদ"), $("#attachmentContainer_" + e).remove() }, error: function(a, e, t) { $.alert("ফাইল ডিলিট সম্পন্ন হয়নি । পূনরায় চেষ্টা করুন ।", "অবহতিকরণ বার্তা") } }) } } })
            },
            hajiraPrintSection: function() {
                var a = window.open();
                newdocument = a.document, newdocument.write($("#hajiraTemplate").html()), newdocument.close(), setTimeout(function() { a.print() }, 500)
            },
            printHajira: function(a) { $(".hajiraDate").html(""), $(".hajiraDate").append($("#conductDate").val()), "APPLICANT" == a ? "ABSENT" === $("input[type='radio'].applicantAttendance:checked").val() ? $.alert("আবেদনকারী অনুপস্থিত।", "অবহিতকরণ বার্তা") : this.hajiraPrintSection() : "DEFAULTER" == a && ("ABSENT" === $("input[type='radio'].defaulterAttendance:checked").val() ? $.alert("ঋণগ্রহীতা অনুপস্থিত।", "অবহিতকরণ বার্তা") : this.hajiraPrintSection()) }
        }
    }
});
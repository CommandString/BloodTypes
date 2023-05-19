import "./base.js";
import "./styles/home.scss";

$('.selection.dropdown')
    .dropdown()
;

const betweenTwo = async function () {
    let type1 = $("#compatibility-one .dropdown.one input").val();
    let type2 = $("#compatibility-one .dropdown.two input").val();

    /**
     * @param type1 {string}
     * @param type2 {string}
     * @param compatible {boolean}'
     * @param direction {string}
     * @returns {string}
     */
    let createItem = (type1, type2, compatible, direction) => {
        return `
            <div class="item">
                <i class="inverted ${compatible ? 'green check' : 'red times'} icon"></i>
                <div class="content">${type1}<i class="arrow ${direction} icon"></i>${type2}</div>
            </div>
        `;
    };

    if (!type1.length || !type2.length) {
        return
    }

    $("#compatibility-one").addClass('loading');

    /**
     * @property {boolean} can_donate_to
     * @property {boolean} can_receive_from
     */
    let item1 = await (fetch(`/api/compatibility/${type1}/${type2}`).then(res => res.json()));

    let html =
        createItem(type1, type2, item1.can_donate_to, 'right') +
        createItem(type1, type2, item1.can_receive_from, 'left');

    $("#compatibility-one .message .list").html(html);
    $("#compatibility-one").removeClass('loading');
};

$("#compatibility-one .dropdown.one input").change(betweenTwo);
$("#compatibility-one .dropdown.two input").change(betweenTwo);

$("#compatibility-two .dropdown input").change(async function () {
    $("#compatibility-two").addClass('loading');

    let donors = await(fetch(`/api/donors/${$(this).val()}`).then(res => res.json()));
    let donorHtml = '';
    for (let i = 0; i < donors.length; i++) {
        donorHtml += `<div class="item">${donors[i]}</div>`;
    }

    let recipients = await(fetch(`/api/recipients/${$(this).val()}`).then(res => res.json()));
    let recipientHtml = '';
    for (let i = 0; i < recipients.length; i++) {
        recipientHtml += `<div class="item">${recipients[i]}</div>`;
    }

    $("#compatibility-two .message .donors.list").html(donorHtml);
    $("#compatibility-two .message .recipients.list").html(recipientHtml);

    $("#compatibility-two").removeClass('loading');
});

$("#properties .dropdown input").change(async function () {
    $("#properties").addClass('loading');

    /**
     * @property {Array<string>} proteins
     * @property {Array<string>} antibodies
     */
    let props = await(fetch(`/api/properties/${$(this).val()}`).then(res => res.json()));
    let proteins = props.proteins;
    let antibodies = props.antibodies;

    let proteinHtml = '';
    for (let i = 0; i < proteins.length; i++) {
        proteinHtml += `<div class="item">${proteins[i]}</div>`;
    }

    let antibodyHtml = '';
    for (let i = 0; i < antibodies.length; i++) {
        antibodyHtml += `<div class="item">${antibodies[i]}</div>`;
    }

    $("#properties .message .proteins.list").html(proteinHtml);
    $("#properties .message .antibodies.list").html(antibodyHtml);

    $("#properties").removeClass('loading');
});
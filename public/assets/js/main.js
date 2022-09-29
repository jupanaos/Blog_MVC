function openTab(evt, dataType) {

    let tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    let tablinks = document.getElementsByClassName("tablinks");
    for (let i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(dataType).style.display = "block";
    evt.currentTarget.className += " active";
}

setTimeout(() => {
    document.getElementById("defaultOpen").click();
}, "300")

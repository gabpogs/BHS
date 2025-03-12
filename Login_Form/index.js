function showform(formID){
    document.querySelectorAll(".form-signin").forEach(form => form.classList.add("d-none"));
    document.getElementById(formID).classList.remove("d-none");
}
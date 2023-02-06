const errors = [
    "An error occurred, Please try again later.",
    "Please fill all fields.",
    "Email address already in use.",
    "Invalid email address or password.",
    "Invalid email format.",
    "Password doesn't meet the requirements.",
    "Invalid name format.",
    "Password confirmation doesn't match.",
    "You are not logged in, Please login to continue.",
];

// get the required form and make it active
const isFormType = window.location.search.match(/formtype=(\d)/i) ?? false;

// initialize formName variable
let formName = "login";

// if there's a formtype in url
if (isFormType) {
    // get the form name that corresponds to the formtype from the url
    formName = +isFormType[1] === 1 ? "signup" : "login";
}

const forms = document.querySelectorAll("form");
// select the required form
const activeForm = document.getElementById(formName);

forms.forEach((form) => {
    if (form === activeForm) {
        form.classList.add("active");
    } else {
        form.classList.remove("active");
    }
});

// check if there is an errorcode in the url
const isErrorCode = window.location.search.match(/errorcode=(\d)/i);

// if there's an error code in url
if (isErrorCode) {
    // get the error code
    const errorCode = (+isErrorCode[1] ?? 0) > errors.length - 1 ? 0 : +isErrorCode[1];

    // get the message that corresponds to the error code from the errors array
    const errorMessage = errors[errorCode];
    // create error notifications container
    const notificationContainer = document.createElement("div");

    // add classes to the error notifications container
    notificationContainer.classList.add("errornotification");

    // add the error message to the error notifications container
    notificationContainer.textContent = errorMessage;
    activeForm.insertAdjacentElement("afterbegin", notificationContainer);
}

// toggle forms classes when clicking on anchor
document.querySelectorAll("form a").forEach(function (anchor) {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        forms.forEach((form) => {
            form.classList.toggle("active");
        });
    });
});

const passSwitchers = document.querySelectorAll(".password-switcher i");

// toggle password visibility
passSwitchers.forEach((switcher) => {
    switcher.addEventListener("click", function (e) {
        const passInputs = this.closest("form").querySelectorAll(".password-switcher-container input");
        passInputs.forEach((input) => {
            input.type = input.type === "password" ? "text" : "password";
        });
        this.classList.toggle("fa-eye");
        this.title = this.title === "Show Password" ? "Hide Password" : "Show Password";
        this.classList.toggle("fa-eye-slash");
    });
});

function username_validation() {
    const element = document.createElement("p");
    element.innerHTML = "A user with this username already exists. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("register").appendChild(element);
}

function email_validation() {
    const element = document.createElement("p");
    element.innerHTML = "A user with this email already exists. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("register").appendChild(element);
}

function login_success() {
    const form = document.getElementById("login")
    form.style.display = "none"
    const p = document.getElementById("register")
    p.style.display = "none"
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    const element = document.createElement("h2");
    element.innerHTML = "Login successful. Redirecting to main page."
    document.getElementById("login_logout").innerHTML = "Logout"
    document.getElementById("form-container").appendChild(element);
    setTimeout(() => {
        window.location.replace("index.php");
      }, 2000);
}

function login_error() {
    const element = document.createElement("p");
    element.innerHTML = "Wrong username or password. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("login").appendChild(element);
}

function date_error() {
    const element = document.createElement("p");
    element.innerHTML = "<br>The property is unavailable during these dates. <br>Please try different dates."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("booking-dates").appendChild(element);
}

function booking_success() {
    const form = document.getElementById("booking-form")
    form.style.display = "none"
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    const element = document.createElement("h2");
    element.innerHTML = "Booking succesful. Thanks for your patronage."
    document.getElementById("booking").appendChild(element);
    setTimeout(() => {
        window.location.replace("index.php");
      }, 3500);
}

function price_calculator(total_price) {
    const element = document.createElement("p");
    element.innerHTML = "The total price for the selected dates is: <br>" + total_price;
    element.style.fontSize = "25px"
    element.style.textAlign = "center"
    document.getElementById("booking-form").appendChild(element)
}

function listing_creation() {
    const form = document.getElementById("create-listing")
    form.style.display = "none"
    console.log("1");
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    console.log("2");
    const element = document.createElement("h2");
    element.innerHTML = "Succesfully listed your property."
    console.log("3");
    document.getElementById("create").appendChild(element);
    setTimeout(() => {
        console.log("4");
        window.location.replace("index.php");
      }, 2000);
}
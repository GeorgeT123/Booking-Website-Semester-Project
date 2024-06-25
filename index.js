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
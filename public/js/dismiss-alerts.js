// Auto-dismiss alerts after 5 seconds
document.addEventListener("DOMContentLoaded", () => {
  // Get all alert elements
  const alerts = document.querySelectorAll(".alert");

  // Set timeout to dismiss each alert after 5 seconds
  alerts.forEach((alert) => {
    setTimeout(() => {
      // Create and dispatch a click event on the close button
      const closeButton = alert.querySelector(".btn-close");
      if (closeButton) {
        closeButton.click();
      } else {
        // If no close button, remove the alert directly
        alert.remove();
      }
    }, 5000); // 5000 milliseconds = 5 seconds
  });
});

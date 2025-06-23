// *************************** [Toast] *************************************************************************

function showToast(message, type = "info") {
  $(".custom-toast").remove();

  const bgColor =
    type === "error" ? "#f8d7da" : type === "success" ? "#d1e7dd" : "#cff4fc";
  const textColor =
    type === "error" ? "#721c24" : type === "success" ? "#0f5132" : "#055160";
  const borderColor =
    type === "error" ? "#f1aeb5" : type === "success" ? "#a3cfbb" : "#b8daff";
  const icon = type === "error" ? "❌" : type === "success" ? "✅" : "ℹ️";

  const toast = $(`
                        <div class="custom-toast toast-${type}" style="
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            z-index: 9999;
                            padding: 16px 20px;
                            background: ${bgColor};
                            color: ${textColor};
                            border: 1px solid ${borderColor};
                            border-radius: 8px;
                            font-size: 14px;
                            font-weight: 500;
                            min-width: 300px;
                            max-width: 400px;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            transform: translateX(100%);
                            opacity: 0;
                            transition: all 0.3s ease-in-out;
                            cursor: pointer;
                        ">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 16px;">${icon}</span>
                                <span style="flex: 1;">${message}</span>
                                <span style="margin-left: 10px; cursor: pointer; font-weight: bold; opacity: 0.7;">&times;</span>
                            </div>
                        </div>
                    `);

  $("body").append(toast);

  setTimeout(() => {
    toast.css({ transform: "translateX(0)", opacity: "1" });
  }, 10);

  const autoRemove = setTimeout(() => removeToast(toast), 5000);

  toast.on("click", function () {
    clearTimeout(autoRemove);
    removeToast(toast);
  });
}

function removeToast(toast) {
  toast.css({ transform: "translateX(100%)", opacity: "0" });
  setTimeout(() => toast.remove(), 300);
}

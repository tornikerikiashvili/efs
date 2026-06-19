(function () {
    var tinymceBaseUrl = "https://cdn.jsdelivr.net/npm/tinymce@6.8.5";

    function editorConfig(textarea) {
        return {
            target: textarea,
            base_url: tinymceBaseUrl,
            suffix: ".min",
            promotion: false,
            branding: false,
            height: parseInt(textarea.dataset.height || "350", 10),
            menubar: false,
            plugins: "lists link autolink code table",
            toolbar:
                "undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | " +
                "alignleft aligncenter alignright alignjustify | bullist numlist blockquote | link | code",
            block_formats:
                "Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6",
            valid_elements: "*[*]",
            extended_valid_elements: "*[*]",
            entity_encoding: "raw",
            convert_urls: false,
        };
    }

    function initRichEditor(textarea) {
        if (!textarea || textarea.dataset.editorInitialized === "true") {
            return;
        }

        if (typeof tinymce === "undefined") {
            return;
        }

        var tabPane = textarea.closest(".tab-pane");

        if (tabPane && !tabPane.classList.contains("active")) {
            return;
        }

        textarea.dataset.editorInitialized = "true";

        tinymce.init(editorConfig(textarea)).catch(function (error) {
            textarea.dataset.editorInitialized = "false";
            textarea.style.display = "block";
            console.error("TinyMCE failed to initialize:", error);
        });
    }

    function initVisibleEditors() {
        document.querySelectorAll(".rich-editor").forEach(initRichEditor);
    }

    function bindFormAndTabs() {
        if (window.jQuery) {
            jQuery('a[data-toggle="tab"]').on("shown.bs.tab", function (event) {
                var target = jQuery(event.target).attr("href");

                if (!target) {
                    return;
                }

                document.querySelectorAll(target + " .rich-editor").forEach(initRichEditor);

                if (typeof tinymce !== "undefined") {
                    tinymce.editors.forEach(function (editor) {
                        editor.fire("ResizeEditor");
                    });
                }
            });
        }

        document.querySelectorAll("form").forEach(function (form) {
            form.addEventListener("submit", function () {
                if (typeof tinymce !== "undefined") {
                    tinymce.triggerSave();
                }
            });
        });
    }

    function boot(attempt) {
        if (typeof tinymce === "undefined") {
            if (attempt < 50) {
                setTimeout(function () {
                    boot(attempt + 1);
                }, 100);
            }

            return;
        }

        initVisibleEditors();
        bindFormAndTabs();
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", function () {
            boot(0);
        });
    } else {
        boot(0);
    }
})();

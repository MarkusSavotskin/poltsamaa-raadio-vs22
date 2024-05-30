class CopyrightYear {
  constructor() {
    this.initListener();
  }

  initListener() {
    window.addEventListener('load', () =>
      CopyrightYear.copyright()
    );
  }

  static copyright() {
    // Find the correct element
    const element = document.getElementById("js-copyright-year")

    const company = element.getAttribute("company")
    const email = element.getAttribute("email")
    const phone = element.getAttribute("phone")

    // Set current year
    const year = new Date().getFullYear();

    element.innerHTML = `© ${year} ${company} | <a>${email}</a> | <a>${phone}</a>`;
  }
}

window.CopyrightYear = new CopyrightYear();

export default CopyrightYear;
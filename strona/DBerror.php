<style>
    .errorBg {
        background-image: url("errorImg.jpg");
        background-size: contain;
        filter: grayscale(1) blur(1px);
        position: fixed;
        top:0;
        left: 0;
        width: 100vw;
        height: 100vh;
    }
    .errorPopup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        width: 600px;
        height: 200px;
        background-color: white;
        font-size: large;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0px 2px 6px 2px #ddd;
    }
    span {
        color: red;
    }
</style>
<div class="errorBg"></div>
<div class="errorPopup">
    <h3>Nie znaleziono bazy danych <i>kantorek_fetter</i></h3>
    <p>Uruchom <span>skrypt main.py</span> aby zainicjalizować bazę danych, pobrać aktualne kursy z NBP i umieścić te danie w bazie. Po tej czynności strona wyświetli się prawidłowo.</p>
</div>
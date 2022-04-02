import requests
import mysql.connector
from mysql.connector import errorcode



class Baza:
    query = "https://api.nbp.pl/api/exchangerates/tables/a/?format=json"
    def __init__(self, host, user, pwd, database=None):
        try:
            self.db = mysql.connector.connect(host=host, user=user, password=pwd, database=database)
        except:
            print("Nie można połączyć się z bazą danych.")
            exit()
        self.cursorDB = self.db.cursor()
    def selectDB(self, db):
        try:
            self.cursorDB.execute(f"USE {db}")
        except mysql.connector.Error as err:
            if(err.errno == 1049):
                print("Baza danych nie istnieje! Tworzę nową i dodaje 10 ostatnich tabel z NBP!")
                self.createDB(db)
                self.cursorDB.execute(f"USE {db}")
                self.cursorDB.fetchall()
                self.query = "https://api.nbp.pl/api/exchangerates/tables/A/last/10/?format=json"
    def createTable(self, table, opt):
        try:
            self.cursorDB.execute(f"DESC {table};")
        except:
            self.cursorDB.execute(f"CREATE TABLE {table} {opt}")
        self.cursorDB.fetchall()
    def createDB(self, db):
        self.cursorDB.execute(f"CREATE DATABASE {db}")
        self.cursorDB.fetchall()
    def delDB(self, db):
        self.cursorDB.execute(f"DROP DATABASE {db}")
        self.cursorDB.fetchall()
    def queryDB(self,q):
        try:
            self.cursorDB.execute(q)
        except mysql.connector.Error as err:
            print(f"[queryDB] Nie można wykonać zapytania, bo {err}")
            return None
        wiersze = []
        for x in self.cursorDB.fetchall():
            wiersze.append(list(x))
        return wiersze
    def commit(self):
        self.db.commit()

    def disconnectDB(self):
        self.db.close()


baza = Baza("localhost", "root", "")
baza.selectDB("kantorek")

class Rate:
    currency=""
    code=""
    mid=""
    def __init__(self, currency, code, mid) -> None:
        self.currency = currency
        self.code = code
        self.mid = mid
class Tabela:
    table="A"
    no=""
    effectiveDate=""
    rates=[]
    def __init__(self, json):
        self.rates = []
        self.table = json['table']
        self.no = json['no']
        self.effectiveDate = json['effectiveDate']
        for rate in json['rates']:
            self.rates.append(Rate(rate['currency'], rate['code'], rate['mid']))
    def __str__(self) -> str:
        return f"{self.no} | {self.effectiveDate} | {self.rates}"

def RequestNaTabele(req):
    r = requests.get(req)
    json = r.json()
    tabele = []
    for tabela in json:
        tabele.append(Tabela(tabela))
    return tabele


aktualnaTabela = RequestNaTabele("https://api.nbp.pl/api/exchangerates/tables/a/?format=json")[0]



tabele = RequestNaTabele(baza.query)


baza.createTable("kursy", "(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nr_tabeli VARCHAR(14), data DATE, kod_waluty VARCHAR(3), kurs FLOAT, nazwa VARCHAR(100));")
baza.createTable("kursUSD", "(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nr_tabeli VARCHAR(14), data DATE, kurs FLOAT);")
baza.createTable("kursGBP", "(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nr_tabeli VARCHAR(14), data DATE, kurs FLOAT);")
baza.createTable("kursEUR", "(id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nr_tabeli VARCHAR(14), data DATE, kurs FLOAT);")


if len(baza.queryDB(f'SELECT * FROM kursy WHERE nr_tabeli = "{aktualnaTabela.no}"')) > 0:
    print("Mamy już zassaną aktualną tabelkę!")
    quit()



for tabela in tabele:
    kursyStr = "INSERT INTO kursy VALUES "
    for kurs in tabela.rates:
        kursyStr += f'(NULL, "{tabela.no}", "{tabela.effectiveDate}", "{kurs.code}", {kurs.mid}, "{kurs.currency}"), '
    kursyStr = kursyStr[:-2] +";"
    baza.queryDB(kursyStr)

    gbp = list(filter(lambda kurs: kurs.code == "GBP", tabela.rates))[0]
    usd = list(filter(lambda kurs: kurs.code == "USD", tabela.rates))[0]
    eur = list(filter(lambda kurs: kurs.code == "EUR", tabela.rates))[0]

    baza.queryDB(f'INSERT INTO kursusd VALUES (NULL, "{tabela.no}", "{tabela.effectiveDate}", {usd.mid})')
    baza.queryDB(f'INSERT INTO kursgbp VALUES (NULL, "{tabela.no}", "{tabela.effectiveDate}", {gbp.mid})')
    baza.queryDB(f'INSERT INTO kurseur VALUES (NULL, "{tabela.no}", "{tabela.effectiveDate}", {eur.mid})')

    baza.commit()

print("Zaktualizowano bazę dodanych dodając aktualne kursy!")

baza.disconnectDB()
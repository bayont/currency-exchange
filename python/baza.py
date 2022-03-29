import mysql.connector
from mysql.connector import errorcode

class Baza:
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
                print("Baza danych nie istnieje! Tworzę nową!")
                self.createDB(db)
                self.cursorDB.execute(f"USE {db}")
                self.cursorDB.fetchall()
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


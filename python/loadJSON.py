import requests

r = requests.get('https://api.nbp.pl/api/exchangerates/tables/a/?format=json')
json = r.json()

def getTableName():
    return json[0]['no']
def getDate():
    return json[0]['effectiveDate']
def getAllCurrencies():
    return json
def getCurrencies(curr,tab=[]):
    if len(tab) > 0:
        return list(filter(lambda w: (w['code'] in tab), json[0]['rates']))
    return list(filter(lambda w: (w['code'] == curr), json[0]['rates']))

def initDB():
    rLastTen = requests.get('https://api.nbp.pl/api/exchangerates/tables/a/last/10/?format=json')
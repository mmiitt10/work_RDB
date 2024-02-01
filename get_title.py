# from selenium import webdriver
# from selenium.webdriver.common.by import By
# from selenium.webdriver.chrome.service import Service  # Serviceをインポート
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support import expected_conditions as EC
# import sys

# # WebDriverのServiceを設定
# webdriver_service = Service(r'C:\xampp\htdocs\test2\chromedriver-win64\chromedriver.exe')
# browser = webdriver.Chrome(service=webdriver_service)

# # URL設定
# url = sys.argv[1]
# browser.get(url)

# # WebDriverWaitを使用して、ページのタイトルが存在するまで最大10秒間待機する
# WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.TAG_NAME, "title")))

# # タイトルを取得
# title = browser.title

# # タイトルを出力
# print(title.encode('utf-8', 'replace').decode('utf-8', 'replace'))


# # ブラウザを閉じる
# browser.quit()

# beautifulsoupに変更して挙動するかどうか確認

import requests
from bs4 import BeautifulSoup
import sys

# URL設定
url = sys.argv[1]

# requestsを使用してウェブページの内容を取得
response = requests.get(url)

# ウェブページのコンテンツをBeautiful Soupで解析
soup = BeautifulSoup(response.content, 'html.parser')

# タイトルを取得
title = soup.title.string if soup.title else 'No title found'

# タイトルを出力
print(title.encode('utf-8', 'replace').decode('utf-8', 'replace'))

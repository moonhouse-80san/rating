라이믹스 게시글 마다 로그인 회원이 평점을 부여 하는 기능을 만들어 볼려고 애드온을 만들다 보니

애드온으로는 DB에 테이블을 생성 시킬 수가 없어서 테이블 생성만 하게 간단한 모듈을 만들었고

애드온에서 모든 것을 처리하게 했다.

만들다 보니 이래 저래 참 어렵네... 모듈은 더욱 더 어려워 내 힘으로는...

 

애드온에서 게시글 본문 아래 자리를 잡을려고 하니 이상하게 자리를 잡으면 평점이 클릭 안되고

평점이 클릭되게 하니 자리에 없고

그래서 직접 게시글 본문안에 코드를 넣는 벙법을 적용했다.(비급한 변명입니다!!!)



이리 저리 해서 거의 완성을 했는데 이번에 AJAX가 작동을 안한다.

그것이 내 실력으로는 AJAX 때문인지 다른데서 문제를 일으키는지도 알 수가 없다

며칠을 고민하고 A.I들에게 물어봐도 정답이 없네 으으으~

![image](https://github.com/user-attachments/assets/ace877ec-ad5c-4fc2-9b6a-d3f23eb98f3b)

![image](https://github.com/user-attachments/assets/59f09f96-70b1-4652-8b62-2a0f1568d0d8)

이 글을 보시는 고수님들이랑 이 기능이 필요하신 분들이 코딩을 보시고 답을 주시기를 고대합니다.

테스트 사이트 : https://moonhouse.co.kr/book

Github 주소 https://github.com/moonhouse-80san/rating

 

증상 :

테스트 페이지에서 평점을 주면 오류 메세지가 츨력됩니다. 

F5 눌러 리로드하면 정상적으로 부여된 평점이 보입니다.

DB의 테이블에도 정상적으로 잘 기재 됩니다.

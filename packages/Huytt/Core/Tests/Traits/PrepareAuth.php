<?php

namespace Huytt\Core\Tests\Traits;

use Huytt\Role\Contracts\Role;

trait PrepareAuth
{
//    private function _prepareAuth() {
//        $repsone = $this->json('post', 'api/v1/auth/login', [
//            'token' => 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImtDc3RfOG92WUZoRzgtZzdDSG9HcTdsV3hxeEpGdFBnZG96bkZjM2xJNFkiLCJhbGciOiJSUzI1NiIsIng1dCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCIsImtpZCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8xZmQxZGZjNC1lNWUzLTRkMzctYWRkYi0zZWNhNDExZWNhZWMvIiwiaWF0IjoxNjQwNTg1NzM3LCJuYmYiOjE2NDA1ODU3MzcsImV4cCI6MTY0MDU5MDA4NywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFVUUF1LzhUQUFBQXhYU2J4YW0vdjU3VHMvRHdVUG8yVmd4b3FZYmdxVXJpTjc0RHZmTWdLQ0RRS2lnZE9GT0cydnE1bmdZUlZQWVNBRE9XOHo0QkJvVXlzcTBzY0xEQ3l3PT0iLCJhbXIiOlsicHdkIiwibWZhIl0sImFwcF9kaXNwbGF5bmFtZSI6Ik5vdmFDUk1TU08iLCJhcHBpZCI6ImFkNWUxNWNiLWFjNzItNDgyYi1hNGM3LWM4ZTczOTA3ZjE2YyIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiVHJhbiBUYW4gKEFURC1OVkxHKSIsImdpdmVuX25hbWUiOiJMYW0sIiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiMjIyLjI1My41Mi40MiIsIm5hbWUiOiJMYW0sIFRyYW4gVGFuIChBVEQtTlZMRykiLCJvaWQiOiI5MDkwODc3Ny02NTBiLTQwOWEtODQ1My1mYTMwMzdlOTUyODMiLCJvbnByZW1fc2lkIjoiUy0xLTUtMjEtMjQ1ODU1Mzk2My0yNTExMzM1ODU4LTU0OTUxNzIyOS00MjgzMSIsInBsYXRmIjoiNSIsInB1aWQiOiIxMDAzMjAwMTZGOTMxQUI5IiwicmgiOiIwLkFWUUF4Tl9SSC1QbE4wMnQyejdLUVI3SzdNc1ZYcTF5ckN0SXBNZkk1emtIOFd4VUFGWS4iLCJzY3AiOiJvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJZa2o0b04waXNScjhyanpBMkxVUmFQd1ZNWEljQUk5N1JWWC1FS3dDZ2U0IiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkFTIiwidGlkIjoiMWZkMWRmYzQtZTVlMy00ZDM3LWFkZGItM2VjYTQxMWVjYWVjIiwidW5pcXVlX25hbWUiOiJsYW0udHJhbnRhbkBub3ZhbGFuZC5jb20udm4iLCJ1cG4iOiJsYW0udHJhbnRhbkBub3ZhbGFuZC5jb20udm4iLCJ1dGkiOiJVUE1RRnc1OG9FbWMzWEl0QmZUdkFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6IjluRW9WQUVmdm1Senp0aGptQ1Q0TC1EYWVUME1KZXJqNEduLVFHc3U1bkUifSwieG1zX3RjZHQiOjE0NDA3NzQ3NjF9.wHVNA_aT_CT9BdSCFjjVHXyLXGPhZgon4mmAGl-qJwH1Gdskgj99zDi0MJiOPCUmENmw9z14mMthZm3zfDeikuwKOeLs1chfekUGlSxqVKvkZ0K6G4mOofVTHwfh7A_NZOwNi228P9zPewhQe9q4aJHa8sFwZhrFCh_yx4hFesYoLUvWVFaz8kdMbQZrta-At1axwzbvF2si7zPLcD5RrFW9YmxjxH0yEiKSTPlP01mBtrLEMgvg0mLNqlnLiiXItmJst0izUueq4pDKzGLQE81kxBZ8KtFdpNl2i2jD6G8Nr4RxRvP-fIoDSox4a3z3sJ3pzgH-VdgI8-XPZsuczA',
//            'isTest' => 1,
//            'email' => 'huy.truongthanh@novaland.com.vn',
//            'roleId' => 20
//        ]);
//        return $repsone->decodeResponseJson()['data']['accessToken'];
//    }
//
//    private function _prepareAuthWithRole($role) {
//        switch ($role) {
//            case Role::ROLE_SALES_MANAGER:
//                $email = 'crmtesting1@novaland.com.vn';
//                break;
//            case Role::ROLE_SUPER_ADMIN:
//                $email = 'crmtesting2@novaland.com.vn';
//                break;
//            case Role::ROLE_SALE_CONSULTANT:
//                $email = 'crmtesting3@novaland.com.vn';
//                break;
//            case Role::ROLE_SALE_ADMIN:
//                $email = 'crmtesting4@novaland.com.vn';
//                $roleId = 4;
//                break;
//            case Role::ROLE_BASKET_ADMIN:
//                $email = 'crmtesting5@novaland.com.vn';
//                $roleId = 24;
//                break;
////            case 'SB1':
////                $email = 'crmtesting6@novaland.com.vn';
////                break;
//            default:
//                $email = 'han.vuthi@novaland.com.vn';
//        }
//
//        $repsone = $this->json('post', 'api/v1/auth/login', [
//            'token' => 'eyJ0eXAiOiJKV1QiLCJub25jZSI6ImtDc3RfOG92WUZoRzgtZzdDSG9HcTdsV3hxeEpGdFBnZG96bkZjM2xJNFkiLCJhbGciOiJSUzI1NiIsIng1dCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCIsImtpZCI6Ik1yNS1BVWliZkJpaTdOZDFqQmViYXhib1hXMCJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC8xZmQxZGZjNC1lNWUzLTRkMzctYWRkYi0zZWNhNDExZWNhZWMvIiwiaWF0IjoxNjQwNTg1NzM3LCJuYmYiOjE2NDA1ODU3MzcsImV4cCI6MTY0MDU5MDA4NywiYWNjdCI6MCwiYWNyIjoiMSIsImFpbyI6IkFVUUF1LzhUQUFBQXhYU2J4YW0vdjU3VHMvRHdVUG8yVmd4b3FZYmdxVXJpTjc0RHZmTWdLQ0RRS2lnZE9GT0cydnE1bmdZUlZQWVNBRE9XOHo0QkJvVXlzcTBzY0xEQ3l3PT0iLCJhbXIiOlsicHdkIiwibWZhIl0sImFwcF9kaXNwbGF5bmFtZSI6Ik5vdmFDUk1TU08iLCJhcHBpZCI6ImFkNWUxNWNiLWFjNzItNDgyYi1hNGM3LWM4ZTczOTA3ZjE2YyIsImFwcGlkYWNyIjoiMCIsImZhbWlseV9uYW1lIjoiVHJhbiBUYW4gKEFURC1OVkxHKSIsImdpdmVuX25hbWUiOiJMYW0sIiwiaWR0eXAiOiJ1c2VyIiwiaXBhZGRyIjoiMjIyLjI1My41Mi40MiIsIm5hbWUiOiJMYW0sIFRyYW4gVGFuIChBVEQtTlZMRykiLCJvaWQiOiI5MDkwODc3Ny02NTBiLTQwOWEtODQ1My1mYTMwMzdlOTUyODMiLCJvbnByZW1fc2lkIjoiUy0xLTUtMjEtMjQ1ODU1Mzk2My0yNTExMzM1ODU4LTU0OTUxNzIyOS00MjgzMSIsInBsYXRmIjoiNSIsInB1aWQiOiIxMDAzMjAwMTZGOTMxQUI5IiwicmgiOiIwLkFWUUF4Tl9SSC1QbE4wMnQyejdLUVI3SzdNc1ZYcTF5ckN0SXBNZkk1emtIOFd4VUFGWS4iLCJzY3AiOiJvcGVuaWQgcHJvZmlsZSBVc2VyLlJlYWQgZW1haWwiLCJzaWduaW5fc3RhdGUiOlsia21zaSJdLCJzdWIiOiJZa2o0b04waXNScjhyanpBMkxVUmFQd1ZNWEljQUk5N1JWWC1FS3dDZ2U0IiwidGVuYW50X3JlZ2lvbl9zY29wZSI6IkFTIiwidGlkIjoiMWZkMWRmYzQtZTVlMy00ZDM3LWFkZGItM2VjYTQxMWVjYWVjIiwidW5pcXVlX25hbWUiOiJsYW0udHJhbnRhbkBub3ZhbGFuZC5jb20udm4iLCJ1cG4iOiJsYW0udHJhbnRhbkBub3ZhbGFuZC5jb20udm4iLCJ1dGkiOiJVUE1RRnc1OG9FbWMzWEl0QmZUdkFBIiwidmVyIjoiMS4wIiwid2lkcyI6WyJiNzlmYmY0ZC0zZWY5LTQ2ODktODE0My03NmIxOTRlODU1MDkiXSwieG1zX3N0Ijp7InN1YiI6IjluRW9WQUVmdm1Senp0aGptQ1Q0TC1EYWVUME1KZXJqNEduLVFHc3U1bkUifSwieG1zX3RjZHQiOjE0NDA3NzQ3NjF9.wHVNA_aT_CT9BdSCFjjVHXyLXGPhZgon4mmAGl-qJwH1Gdskgj99zDi0MJiOPCUmENmw9z14mMthZm3zfDeikuwKOeLs1chfekUGlSxqVKvkZ0K6G4mOofVTHwfh7A_NZOwNi228P9zPewhQe9q4aJHa8sFwZhrFCh_yx4hFesYoLUvWVFaz8kdMbQZrta-At1axwzbvF2si7zPLcD5RrFW9YmxjxH0yEiKSTPlP01mBtrLEMgvg0mLNqlnLiiXItmJst0izUueq4pDKzGLQE81kxBZ8KtFdpNl2i2jD6G8Nr4RxRvP-fIoDSox4a3z3sJ3pzgH-VdgI8-XPZsuczA',
//            'isTest' => 1,
//            'email' => $email,
//            'roleId' => $roleId
//        ]);
//        return $repsone->decodeResponseJson()['data']['accessToken'];
//
//    }
}

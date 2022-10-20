@extends('layouts/temp', ['activePage' => 'login', 'title' => 'DOrSU'])
@section('content')
<style>
    .card-title{
        font-size: 21px;
        font-weight: 700;
        color: #2C3333;
    }
    .d-flex .card:hover{
        transform: scale(1.01);
        transition: 1s;
        box-shadow: 3px 3px 7px rgb(70,100,100);
    }

    .card-body{
      line-height: 20px;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-box-orient: vertical;
      -webkit-line-clamp: 9;
      line-clamp: 2;
      overflow: hidden;
      transition: 1s;
    }

    
    .card-min{
        height: 440px;
    }

    .d-flex{
        max-width: 470px;
        min-width: 280px;
    }
    .footer{
        padding: 20px;
    }
</style>
<div class="col-sm-10">
    <div class="row justify-content-center">
        @foreach($authorize as $app)
            <div class="col-4 d-flex">
                    <div class="card mb-4 box-shadow card-min">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;"
                        @if($app->img_link == null || $app->img_link == '') 
                            src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_183b0118c09%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_183b0118c09%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71875%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"
                        @else
                            src="{{$app->img_link}}"
                        @endif
                        data-holder-rendered="true">
                        <div class="card-body pb-0">
                            <div class="card-title col-12">
                                <p>{{$app->name}}</p>
                            </div>
                                <p class="text-justify mb-0">{{$app->about}}</p>
                        </div>
                        <div class="footer">
                            <button value="1" class="btn btn-default">More Details</button>
                            <a href="{{$app->link}}" class="btn btn-primary ml-1" target="_blank">Open</a>
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    $(function(){
        $(".btn-default").each(function(i){
            $(this).click(function(){
                if($(this).val() == 1){
                    $(".card").eq(i).attr('class',"card mb-4 box-shadow");
                    $(this).text("Hide Details");
                }else{
                    $(".card").eq(i).attr('class',"card card-min mb-4 box-shadow");
                    $(this).text("More Details");
                }
                $(this).val( -$(this).val());
            })
        })
    })
</script>
@endsection
//wait for DOM ready
$(function() {



  /**
   * function to start a new game
   *
   */

  function startNewGame() {
    $.ajax({
      url: "start_new_story.php",
      dataType: "json",
      data: {
        game_id : 0,
        create_player: {
          "class" : "Aria",
          "name" : "aName"
        }
      },
      success: playNextEvent,
      error: function(data) {
        console.log("startNewGame error: ", data.responseText);
      }
    });
  }



  /**
   * function to play the next chapter event
   *
   */

  function playNextEvent() {
    //get current chapter event data from play_chapter.php
    $.ajax({
      url: "play_chapter1.php",
      dataType: "json",
      success: printEventData,
      error: function(data) {
        //console.log("playNextEvent error: ", data.responseText);
		//$("#game_result").html(data.responseText);
      }
    });
  }



  /**
   * function to print event data to DOM
   *
   */

  function printEventData(eventData) {
    console.log("got eventData: ", eventData);

    //if event data is false, assume we are starting a new game
    if (eventData === false) {
      $(".storyEvent").html("<h2>It's time to start a new game!</h2>");
      $(".storyOptions").html('<button class="newGame">Start new game!</button>');

      //new game clickHandler
      $(".newGame").click(function() {
        startNewGame();
      });

      return;
    }
    //if event data is an empty array, assume we have completed the game
    else if (eventData.length === 0) {
      $(".storyEvent").html("<h2>You have completed the game!</h2>");
      $(".storyOptions").html('<button class="startOver">Start over</button>');

      //start over clickhandler
      $(".startOver").click(function() {
        startOver();
      });

      return;
    }

    //get rid of array from AJAX result
    eventData = eventData[0];

    //empty DOM "printing" areas
    $(".storyEvent").html("");
    $(".storyOptions").html("");

    //then append event data to DOM
    $(".storyEvent").append("<h2>"+eventData.title+"</h2>");
    $(".storyEvent").append("<p>"+eventData.description+"</p>");

    //then print event options
    var eventOptions = eventData.options;
    for (var i = 0; i < eventOptions.length; i++) {
      //create a new button using jQuery
      var option = $('<button>'+eventOptions[i].name+'</button>');
      //attach option data using jQuery .data()
      option.data("option", eventOptions[i]);

      //then append option button to DOM
      $(".storyOptions").append(option);
    }

    //add option clickHandler
    $(".storyOptions button").click(function() {
      //get action data from button .data()
      var thisOption = $(this).data("option");

      //then do the action!
      doOption(thisOption);
    });
  }



  /**
   * function to do an option selected by user
   *
   */

  function doOption(option) {
    $.ajax({
      url: "do_option.php",
      dataType: "json",
      data: {
        option: option
      },
      success: printDoOptionLog,
      error: function(data) {
        console.log("doOption error: ", data.responseText);
      }
    });
  }



  /**
   * function to print doOption log to DOM
   *
   */

  function printDoOptionLog(doOptionData) {
    //empty DOM "printing" areas
    $(".storyEvent").html("");
    $(".storyOptions").html("");

    for (var i = 0; i < doOptionData.length; i++) {
      $(".storyEvent").append("<h3>"+doOptionData[i]+"</h3>");
    }

    $(".storyOptions").append("<button>Play next event...</button>");

    //add option clickHandler
    $(".storyOptions button").click(function() {
      //get action data from button .data()
      playNextEvent();
    });
  }


  /**
   * function to start over
   *
   */

  function startOver() {
    $.ajax({
      url: "reset.php",
      dataType: "json",
      data: {
        startOver: 1
      },
      success: startNewGame,
      error: function(data) {
        console.log("startOver error: ", data.responseText);
      }
    });
    startNewGame();
  }

  //always call playNextEvent on DOMReady
  //playNextEvent();
  
  
  
  
  
  //mm
  /**
   * function to play the next chapter event
   *
   */
  function playNextChapter(userName) {
	var uname = $.trim($("#name").val()); 
	if(uname)
	{  
		//get current chapter event data from play_chapter.php
		$.ajax({
		  url: "play_chapter.php",
		  dataType: "json",
		  data: {
  		    q:'start',
			name:uname,
			user:userName
		  },
		  success: printChapterEventData,
		  error: function(data) {
			//console.log("startNewGame error: ", data.responseText);
			$("#game_result").html(data.responseText);
		  }
		});
	}
	else
		alert("Please enter name");
  }
  
   /**
   * function to print event data to DOM
   *
   */

  function printChapterEventData(eventData) {
	
	$(".storyEvent").html("");
	$(".storyOptions").html("");
	$(".storyOptions1").html("");
	$("#user_select").html("");

    $(".storyEvent").html("Welcome to Random Challenge ("+eventData.name+")");
    $(".storyOptions").append("<h2>"+eventData.title+"</h2>");
    $(".storyOptions").append("<p>"+eventData.description+"</p>");
	
	$(".storyOptions").append('<input type="submit" name="accept_challenge" id="accept_challenge" value="Accept Challenge">');
	$(".storyOptions").append('<input type="submit" name="new_challenge" id="new_challenge" value="New Challenge">');


  }
  $("#terrans").click(function() {
       playNextChapter('terrans');
  });
  $("#zerg").click(function() {
       playNextChapter('zerg');
  });
  $("#protoss").click(function() {
       playNextChapter('protoss');
  });
	  
	  
	  
  /**
   * function to choose challenge
   *
   */
  function chooseChallenge() {
		//get current chapter event data from play_chapter.php
		$.ajax({
		  url: "play_chapter.php",
		  dataType: "json",
		  data: {
  		    q:'choose_challenge'
		  },
		  success: printChooseChallengeEventData,
		  error: function(data) {
			$("#game_result").html(data.responseText);
		  }
		});
  }
  
   /**
   * function to print event data to DOM
   *
   */
  function printChooseChallengeEventData(eventData) {
	console.log(eventData[0]);
	//console.log($.parseJSON(eventData));
	 
	$(".storyEvent").html("");
	$(".storyOptions").html("");
	$(".storyOptions1").html("");
	$("#user_select").html("");
	$(".storyItem").html("");

    $(".storyEvent").html("Welcome to Random Challenge ("+eventData[0].user.name+")");
    $(".storyOptions").append("<h2>"+eventData[0].challenge.title+"</h2>");
    $(".storyOptions").append("<p>"+eventData[0].challenge.description+"</p>");
	
 	if(typeof eventData[0].challenge.stamina!='undefined'){
		$(".storyOptions").append("<p>stamina :"+eventData[0].challenge.stamina+"</p>");
	}
	if(typeof eventData[0].challenge.health!='undefined'){
		$(".storyOptions").append("<p>health :"+eventData[0].challenge.health+"</p>");
	}
	if(typeof eventData[0].challenge.strength!='undefined'){
		$(".storyOptions").append("<p>strength :"+eventData[0].challenge.strength+"</p>");
	}
	if(typeof eventData[0].challenge.speed!='undefined'){
		$(".storyOptions").append("<p>speed :"+eventData[0].challenge.speed+"</p>");
	}
	
	if(typeof eventData[0].item[0]!='undefined'){
		$(".storyItem").append("<p><strong>Item</strong>("+eventData[0].item.length+")<br />"+eventData[0].item[0].title+" </p>");
	}
	
	$(".storyStatus").html("");
	$(".storyStatus").append("<p>Status : "+eventData[0].point+"</p>");
	$(".storyStatus").append("<p>Start Over</p>");
	
	$(".storyOptions").append('<input type="submit" name="play_challenge" id="play_challenge" value="Play Challenge">');
	$(".storyOptions").append('<input type="submit" name="play_challenge_together" id="play_challenge_together" value="Play Challenge Together">');

  }
  $(document).on('click', '#accept_challenge', function()
  {
		chooseChallenge();
  })
  
  
  gameEnd = 0;
  
   /**
   * function to play challenge
   *
   */
  function playChallenge(t) {
	  //if(gameEnd==0)
	  //{
		//get current chapter event data from play_chapter.php
		$.ajax({
		  url: "play_chapter.php",
		  dataType: "json",
		  data: {
  		    q:t
		  },
		  success: printPlayChallengeEventData,
		  error: function(data) {
			$("#game_result").html(data.responseText);
		  }
		});
		
		console.log("ajax Playclicked");
		
	  //}
	  //else
	  //	alert("Game End");
  }
  
   /**
   * function to print event data to DOM
   *
   */
  playChallengeCount = 1;
  function printPlayChallengeEventData(eventData) {
	  
 	//console.log(eventData[0]);
	  
	//console.log("last jmj wwwwwwwwwww");
	//console.log(eventData[0].length);
	
	//console.log("last jmj" + eventData[0]);
	
	
	//check if user has left for play game
	if(typeof eventData[0]=='undefined' || eventData[0]==0)
  	{
		alert("Game End");
	}
	else{
	
		$(".storyEvent").html("");
		$(".storyOptions").html("");
		$(".storyItem").html("");
		$(".storyStatus").html("");
		 
		$(".storyEvent").html("Welcome to Random Challenge ("+eventData[0][0].user.name+")");
		$(".storyOptions").append("<h2>"+eventData[0][0].challenge.title+"</h2>");
		$(".storyOptions").append("<p>"+eventData[0][0].challenge.description+"</p>");
		
		 
		$(".storyOptions").append("<p>"+eventData[1].challenge_property+" : "+eventData[1].challenge_value+"</p>");
		//display items list
		
		console.log(eventData[0][0].item.length);
		$(".storyItem").html("");
		var itemDetail = '';
		for (var j = 0; j < eventData[0][0].item.length; j++) {
			  if(typeof eventData[0][0].item[j].title!='undefined'){
				itemDetail += "<span>"+eventData[0][0].item[j].title + "</span><br />";
			  }
			  else{
				itemDetail += "<span>No item found</span>";
			  }
		}
		$(".storyItem").html("<p><strong>Items</strong>("+eventData[0][0].item.length+")<br />"+itemDetail+"</p>");
		itemDetail='';
			  
 		
		$("#all_user_list").append("<tbody>");
		
		$("#all_user_list").append('<tr><td colspan="6" valign="top">'+eventData[0][0].challenge.title+' ('+eventData[1].challenge_property+" : "+eventData[1].challenge_value+')</td></tr>');
		
		if(playChallengeCount==1){
			$("#all_user_list").append('<tr><td valign="top"><strong>User</strong></td><td valign="top">&nbsp;</td><td><strong>Items</strong></td><td><strong>Challenge Property Left</strong></td><td>&nbsp;</td></tr>');
		}
	 
		
		/*$("#all_user_list").append('<tr><td width="13%" valign="top">Zerg  ( ashu )  : </td><td width="10%" valign="top">Health : 10</td><td width="8%">Challenge :</td>\
			<td width="8%">Health : 50</td><td width="18%">Zerg loose the game</td><td width="43%">&nbsp;</td></tr>');*/
		
		var userName;
		var userProperty;
		//var challengeProperty;
		var challengePropertyValue;
		var checkWin = 0;
		var eresult;
		var item_list;
		 
		//console.log(eventData[0].length);
		
		//console.log("user length : " + eventData[0].length);
		
		
		for (var i = 0; i < eventData[0].length; i++) {
			
		 if(eventData[1].challenge_property=='health'){
				userProperty = eventData[0][i].user.health;	 
				//challengeProperty = eventData[0][0].challenge.health;
		 }else if(eventData[1].challenge_property=='stamina'){
				userProperty = eventData[0][i].user.stamina;	
				//challengeProperty = eventData[0][0].challenge.stamina;
		 }else if(eventData[1].challenge_property=='strength'){
				userProperty = eventData[0][i].user.strength;	 
				//challengeProperty = eventData[0][0].challenge.strength;
		 }else if(eventData[1].challenge_property=='speed'){
				userProperty = eventData[0][i].user.speed;
				//challengeProperty = eventData[0][0].challenge.speed;	 
		 }
		 
		 if(typeof eventData[0][i].user.temp_challenge_value!='undefined'){
			 challengePropertyValue = eventData[0][i].user.temp_challenge_value;
		 }else{challengePropertyValue = 0; }
		 
		 
			//console.log( "success point = "+ eventData[0][i].user.success_point);
		
			if(eventData[0][i].user.result=='won'){
				eresult = 'won the game';
				checkWin = 1;
			}else{ eresult ='lose the game'  }
			 
		
		  if(i==0){
			userName = ' ( '+eventData[0][0].name+' ) ';
			$(".storyStatus").html("<p>Status : "+eventData[0][0].user.success_point+"</p>");
			$(".storyStatus").append("<p>Start Over</p>");
		  }
		  
		  
		  //for item display
		  //console.log( "Item count = " +eventData[0][i].user.name+ " : " + eventData[0][i].item.length);
		  item_list = '';item_list += "<p>";
		  item_list += "<span> ("+eventData[0][i].item.length + ")</span><br />";
		  for (var j = 0; j < eventData[0][i].item.length; j++) {
			  
			  
			  if(typeof eventData[0][i].item[j].title!='undefined'){
				item_list += "<span>"+eventData[0][i].item[j].title + "</span><br />";  
			  }
			  else{
				item_list += "<span>No item found</span><br />";
			  }
			 
			  
			  //console.log(eventData[0][i].item[j].title);
		  } 
		  
		  item_list += "</p><br />";
		  //console.log(item_list);
		  
		  
		  
		 $("#all_user_list").append('<tr><td width="21%" valign="top">'+eventData[0][i].user.name+' '+userName+' : </td>\
										<td width="10%" valign="top">'+eventData[1].challenge_property+' : '+userProperty+'</td><td width="20%">'+item_list+'</td>\
										<td width="17%">'+eventData[1].challenge_property+' : '+challengePropertyValue+'</td><td width="18%"> '+eresult+'   ('+eventData[0][i].user.position+') > ('+eventData[0][i].user.success_point+')</td>\
									 </tr>');
			
			userName = '';
			userProperty = '';	
			//challengeProperty = '';	
			challengePropertyValue = '';
			eresult = '';
			item_list = '';		
			
			
			if(eventData[0][i].user.success_point>=100) 
			{ //gameEnd = 1; 
			}
			else{}
			
			//console.log(eventData[0][i].user.success_point);
				 
		} 
		
		
		$("#all_user_list").append("</tbody>");
		
		
		//console.log(checkWin);
		if(checkWin==0){
			$(".storyOptions").append('<input type="submit" name="play_challenge" id="play_challenge" value="Play Again">');
			
			if(eventData[0].length==1){
			}else{
				$(".storyOptions").append('<input type="submit" name="play_challenge_together" id="play_challenge_together" value="Play Challenge Together">');
			}
			
		}
		else{
			$(".storyOptions").append('<input type="submit" name="next_challenge" id="next_challenge" value="Next Challenge">');
			checkWin = 0;
		}
		playChallengeCount++;
	
	
  }
	
 	
	
	//console.log(gameEnd);
	
	
/*	$(".storyItem").append("<p>Items : <br />"+eventData[0].item.title+"</p>");
	if(typeof eventData[0].item.stamina!='undefined'){
		$(".storyItem").append("<p>Stamina :"+eventData[0].item.stamina+"</p>");
	}
	if(typeof eventData[0].item.health!='undefined'){
		$(".storyItem").append("<p>Health :"+eventData[0].item.health+"</p>");
	}
	if(typeof eventData[0].item.strength!='undefined'){
		$(".storyItem").append("<p>Strength :"+eventData[0].item.strength+"</p>");
	}
	if(typeof eventData[0].item.speed!='undefined'){
		$(".storyItem").append("<p>Speed :"+eventData[0].item.speed+"</p>");
	}
*/	
	
	//console.log(eventData[1]);
	/*var userslist;
	var property;
	var userName;
	for (var i = 0; i < eventData.length; i++) {
      //userslist += doOptionData[i].name;
	  //userslist += '<tr><td width="11%">'+eventData[i].name+'</td><td width="65%"><p>Health : 50</p><p>stamina : 50</p></td><td width="24%">&nbsp;</td></tr>';
	  
	  console.log(eventData[i].user.name + " = " + eventData[i].user.speed);
	  if(i==0){
	  	userName = ' ( '+eventData[0].name+' ) ';
	  }
	  
	  property  = 'Health : '+eventData[i].user.health+'<br>';
	  property += 'Stamina : '+eventData[i].user.stamina+'<br>';
	  property += 'Strength : '+eventData[i].user.strength+'<br>';
	  property += 'Speed : '+eventData[i].user.speed+'<br>';
	  
	  userslist  = '<tr>';
	  userslist += '<td width="23%" valign="top">'+eventData[i].user.name+' '+userName+' : </td>';
	  userslist += '<td width="53%" valign="top">'+property+'</td>';
	  userslist += '<td width="24%">&nbsp;</td>';
	  userslist += '</tr>';
	  $("#all_user_list").append(userslist);
	  
	  userslist = '';
	  property = '';
	  userName = '';
    }	*/
	
	//$("#all_user_list").html(userslist);
	
 	//$(".storyOptions").append('<input type="submit" name="play_challenge" id="play_challenge" value="Play Challenge">');
	//$(".storyOptions").append('<input type="submit" name="play_challenge_together" id="play_challenge_together" value="Play Challenge Together">');
 
  }
  $(document).on('click', '#play_challenge', function()
  {
		playChallenge('play_challenge');
		
  })
  $(document).on('click', '#next_challenge', function()
  {
		playChallenge('next_challenge');
		chooseChallenge();
  })
  $(document).on('click', '#play_challenge_together', function()
  {
		playChallenge('play_challenge_together');
  })
  $(document).on('click', '#new_challenge', function()
  {
		playChallenge('new_challenge');
		chooseChallenge();
  })
});
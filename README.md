# Arbitrage App

This app was made for personal use. It consumes the apis of two cryptocurrency exchanges in order to compare the
current prices of certain coins on each exchange and determine if there is a viable arbitrage opportunity, and the
risk level of the gap closing in the time it takes for the coin to move from one exchange to another (typically 20min 
at time of coding).


## The premise

A large arbitrage opportunity, with gaps in price sometimes in excess of 40%, was available between the Australian 
and korean Cryptocurrency exchanges at the time of coding. Korea has a limit to the amount of local currency that can 
be transferred out of the country so simply sending, withdrawing, and routing home was not a long term option.
I realised that the volatility of the market caused the gap to greatly fluctuate multiple times over a 24 hour period.
This meant that if cash was held on the australian exchange in wait for a coin to present a large gap (judged on a 24 
hour average) I could quickly buy that coin, send it to the korean exchange and sell it immediately for local currency. 
This cash was then held on the korean exchange until a suitably low gap (again judged on a 24 hour average) presented 
itself at which time I could buy the coin, send it to aus, and sell it immediately. This ultimately resulted in a modest 
profit depending on the gap.

With carefull calculations and the use of this application I was able to ensure that I only returned 
coins to the Australian exchange during an involatile time, on a gap that was low enough to ensure maximum profit from 
the original trade was retained.

PLEASE NOTE: 
If you intend to use this tactic ensure that market spread and exchange fees are taken into account. 
Gaps that seem lucrative often are not! Remember that a small percentage of a high number is greater than the same 
percentage of a small number!
Example: $4000 worth of a currency bought in aus and sent to korea on a 20% gap may convert to $4757 after fees but a
returned on a 12% gap will loose 12% of the higher value ($4757*.12 = 570.824636) not the original value ($4000*.12 = 
480).
Such a move will only result in a 3.1% total return once fees are taken into account. 
It's easy to think 20%-12% will equal 8% but hopefully the example above will help avoid this pitfall.

## The process:

1) A cronjob on the server must be set up to call data/apis.php once every minute, and data/krwAud.php (currency 
conversion api call) once a day.

2) data/apis.php runs a timed function that sleeps for 10 seconds each time- this helps keep time and also avoids
going over api rate limits. Using a cronjob helps performance over using the timed loop into infinity. It also helps 
with accuracy of the timing functions.

2) apis.php calls each of the modules, the first two of which make api calls to the exchanges and consume the data,
storing required information in a JSON file.

3) The next module is called that records and compares the price gaps between each coin over the course of an hour
day, week, and month. This information is stored in a JSON file that is updated each time the module is called (10
times/min).
During this process, originally, if a recorded gap was within the set target range an alert was sent out via text and 
email to the user (me). This functionality has been removed from the github version, however I have left the functions 
(commented out) for anyone curious about the functionality.

4) A final module is called that consumes the JSON data produced by the previous modules and creates a list of changes
in the price gap (labeled "slips" for the slip in the gap) between the markets for each coin, every 10 seconds, over 
the course of 30 min (Safety net time for transfer of coins from one exchange to another).
This data shows the lowest change in the gap (bestSlip), the highest change (worstSlip), and the average slip. 
By looking at these changes made it possible to determine how likely the gap was to change during the transfer between
exchanges, and therefore how risky the transfer would be.

5) Javascript functions make calls to the various JSON files, cunsuming the data and constantly updating the display 
on the web site for human consumption.

It can be run on any server that has php enabled

